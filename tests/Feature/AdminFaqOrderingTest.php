<?php

namespace Tests\Feature;

use App\FaqOrder;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Tests\TestCase;

class AdminFaqOrderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_authenticated_admin_can_reorder_faqs(): void
    {
        $this->putJson(route('admin.faqs.reorder'), [
            'ids' => [1],
            'snapshot' => str_repeat('a', 64),
        ])->assertUnauthorized();
    }

    public function test_reorder_persists_one_global_order_including_inactive_faqs(): void
    {
        $this->actingAs(User::factory()->create());
        $first = $this->createFaq('Pertanyaan pertama?', 4, true);
        $second = $this->createFaq('Pertanyaan kedua?', 8, false);
        $third = $this->createFaq('Pertanyaan ketiga?', 12, true);
        $updatedAt = $first->updated_at->toDateTimeString();

        $this->get(route('admin.faqs.index'))
            ->assertOk()
            ->assertSee('data-reorder-url', false)
            ->assertSee('panah atas atau bawah');

        $this->putJson(route('admin.faqs.reorder'), [
            'ids' => [$third->id, $first->id, $second->id],
            'snapshot' => $this->snapshot(),
        ])->assertOk()->assertJsonPath('message', 'Urutan FAQ tersimpan.');

        $this->assertSame([$third->id, $first->id, $second->id], Faq::ordered()->pluck('id')->all());
        $this->assertSame([1, 2, 3], Faq::ordered()->pluck('sort_order')->all());
        $this->assertSame($updatedAt, $first->fresh()->updated_at->toDateTimeString());
        $this->assertFalse($second->fresh()->is_active);
    }

    public function test_duplicate_missing_extra_and_non_integer_ids_are_rejected_without_partial_updates(): void
    {
        $this->actingAs(User::factory()->create());
        $first = $this->createFaq('Pertanyaan pertama?', 1);
        $second = $this->createFaq('Pertanyaan kedua?', 2);
        $snapshot = $this->snapshot();

        foreach ([
            [$first->id, $first->id],
            [$first->id],
            [$first->id, $second->id, 999],
            [(string) $first->id, $second->id],
        ] as $ids) {
            $this->putJson(route('admin.faqs.reorder'), [
                'ids' => $ids,
                'snapshot' => $snapshot,
            ])->assertStatus(in_array($ids, [[$first->id, $first->id], [(string) $first->id, $second->id]], true) ? 422 : 409);
        }

        $this->assertSame([$first->id, $second->id], Faq::ordered()->pluck('id')->all());
        $this->assertSame([1, 2], Faq::ordered()->pluck('sort_order')->all());
    }

    public function test_changed_record_or_new_faq_makes_an_old_snapshot_stale(): void
    {
        $this->actingAs(User::factory()->create());
        $first = $this->createFaq('Pertanyaan pertama?', 1);
        $second = $this->createFaq('Pertanyaan kedua?', 2);
        $snapshot = $this->snapshot();

        $first->update(['question' => 'Pertanyaan telah diubah?']);
        $this->putJson(route('admin.faqs.reorder'), [
            'ids' => [$second->id, $first->id],
            'snapshot' => $snapshot,
        ])->assertStatus(409);

        $freshSnapshot = $this->snapshot();
        $third = $this->createFaq('Pertanyaan baru?', 3);
        $this->putJson(route('admin.faqs.reorder'), [
            'ids' => [$second->id, $first->id],
            'snapshot' => $freshSnapshot,
        ])->assertStatus(409);

        $this->assertSame([$first->id, $second->id, $third->id], Faq::ordered()->pluck('id')->all());
    }

    public function test_filtered_list_disables_reordering_and_explains_why(): void
    {
        $this->actingAs(User::factory()->create());
        $this->createFaq('Pertanyaan pertama?', 1);
        $this->createFaq('Pertanyaan kedua?', 2, false);

        $this->get(route('admin.faqs.index', ['status' => 'inactive']))
            ->assertOk()
            ->assertSee('Pengurutan tersedia pada tab Semua saat pencarian kosong.')
            ->assertDontSee('data-reorder-url', false)
            ->assertSee('data-sort-handle disabled', false);

        $this->get(route('admin.faqs.index', ['search' => 'Pertanyaan']))
            ->assertOk()
            ->assertDontSee('data-reorder-url', false);
    }

    public function test_deletion_closes_order_gaps_without_changing_remaining_records(): void
    {
        $this->actingAs(User::factory()->create());
        $first = $this->createFaq('Pertanyaan pertama?', 1);
        $second = $this->createFaq('Pertanyaan kedua?', 2, false);
        $third = $this->createFaq('Pertanyaan ketiga?', 3);

        $this->delete(route('admin.faqs.destroy', $second))->assertRedirect(route('admin.faqs.index'));

        $this->assertSame([$first->id, $third->id], Faq::ordered()->pluck('id')->all());
        $this->assertSame([1, 2], Faq::ordered()->pluck('sort_order')->all());
    }

    public function test_database_failure_rolls_back_every_position_change(): void
    {
        $this->actingAs(User::factory()->create());
        $first = $this->createFaq('Pertanyaan pertama?', 1);
        $second = $this->createFaq('Pertanyaan kedua?', 2);
        $third = $this->createFaq('Pertanyaan ketiga?', 3);
        $snapshot = $this->snapshot();
        $updates = 0;

        DB::listen(function ($query) use (&$updates): void {
            if (str_starts_with(strtolower($query->sql), 'update') && str_contains($query->sql, 'sort_order')) {
                $updates++;

                if ($updates === 2) {
                    throw new RuntimeException('Simulasi kegagalan penyimpanan urutan.');
                }
            }
        });

        $this->putJson(route('admin.faqs.reorder'), [
            'ids' => [$third->id, $first->id, $second->id],
            'snapshot' => $snapshot,
        ])->assertStatus(500);

        $this->assertSame([$first->id, $second->id, $third->id], Faq::ordered()->pluck('id')->all());
        $this->assertSame([1, 2, 3], Faq::ordered()->pluck('sort_order')->all());
    }

    private function createFaq(string $question, int $sortOrder, bool $active = true): Faq
    {
        return Faq::query()->create([
            'question' => $question,
            'slug' => 'faq-'.$sortOrder,
            'short_answer' => 'Jawaban belum tersedia.',
            'is_active' => $active,
            'sort_order' => $sortOrder,
        ]);
    }

    private function snapshot(): string
    {
        return app(FaqOrder::class)->snapshot(Faq::query()->ordered()->get());
    }
}
