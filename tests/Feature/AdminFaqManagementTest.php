<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFaqManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_faq_management_or_mutate_records(): void
    {
        $faq = Faq::create([
            'question' => 'Pertanyaan contoh?',
            'slug' => 'pertanyaan-contoh',
            'short_answer' => 'Jawaban contoh.',
            'sort_order' => 1,
        ]);

        foreach (['admin.faqs.index', 'admin.faqs.create'] as $route) {
            $this->get(route($route))->assertRedirect(route('admin.login'));
        }

        $this->get(route('admin.faqs.show', $faq))->assertRedirect(route('admin.login'));
        $this->get(route('admin.faqs.edit', $faq))->assertRedirect(route('admin.login'));
        $this->post(route('admin.faqs.store'), [])->assertRedirect(route('admin.login'));
        $this->patch(route('admin.faqs.status', $faq))->assertRedirect(route('admin.login'));
        $this->delete(route('admin.faqs.destroy', $faq))->assertRedirect(route('admin.login'));
        $this->assertDatabaseCount('faqs', 1);
    }

    public function test_create_sanitizes_full_answer_and_assigns_unique_stable_slug_and_order(): void
    {
        $this->actingAs(User::factory()->create());

        $payload = [
            'question' => '  Bagaimana prosedur hemodialisis dilakukan?  ',
            'short_answer' => '  Jawaban singkat.  ',
            'full_answer' => '<p>Isi <strong>penting</strong>.</p><script>alert(1)</script><iframe src="https://example.test"></iframe><img src=x onerror=alert(1)><a href="javascript:alert(1)" onclick="alert(1)">Buruk</a><a href="data:text/html,test">Data</a><a href="https://example.test">Aman</a><a href="tel:123">Telepon</a>',
            'is_active' => '0',
        ];

        $this->post(route('admin.faqs.store'), $payload)->assertRedirect(route('admin.faqs.index'));
        $this->post(route('admin.faqs.store'), $payload)->assertRedirect(route('admin.faqs.index'));

        $faqs = Faq::ordered()->get();
        $this->assertSame([1, 2], $faqs->pluck('sort_order')->all());
        $this->assertSame('bagaimana-prosedur-hemodialisis-dilakukan', $faqs[0]->slug);
        $this->assertSame('bagaimana-prosedur-hemodialisis-dilakukan-2', $faqs[1]->slug);
        $this->assertSame('Jawaban singkat.', $faqs[0]->short_answer);
        $this->assertFalse($faqs[0]->is_active);
        $this->assertStringContainsString('<strong>penting</strong>', $faqs[0]->full_answer);
        $this->assertStringContainsString('href="https://example.test"', $faqs[0]->full_answer);
        $this->assertStringContainsString('href="tel:123"', $faqs[0]->full_answer);
        foreach (['script', 'iframe', 'img', 'onerror', 'onclick', 'javascript:', 'data:'] as $unsafe) {
            $this->assertStringNotContainsString($unsafe, $faqs[0]->full_answer);
        }

        $this->put(route('admin.faqs.update', $faqs[0]), [
            'question' => 'Pertanyaan diubah?',
            'short_answer' => 'Jawaban diubah.',
            'full_answer' => '<p>&nbsp;<br></p>',
            'is_active' => '1',
        ])->assertRedirect(route('admin.faqs.index'));

        $this->assertSame('bagaimana-prosedur-hemodialisis-dilakukan', $faqs[0]->fresh()->slug);
        $this->assertNull($faqs[0]->fresh()->full_answer);
        $this->assertTrue($faqs[0]->fresh()->is_active);
    }

    public function test_validation_preserves_input_and_rejects_whitespace_only_fields(): void
    {
        $this->actingAs(User::factory()->create());

        $this->from(route('admin.faqs.create'))->post(route('admin.faqs.store'), [
            'question' => '   ',
            'short_answer' => " \n\t ",
            'full_answer' => '<p>Contoh</p>',
            'is_active' => '2',
        ])->assertRedirect(route('admin.faqs.create'))
            ->assertSessionHasErrors(['question', 'short_answer', 'is_active']);

        $this->get(route('admin.faqs.create'))->assertOk()->assertSee('<p>Contoh</p>', false);
        $this->assertDatabaseCount('faqs', 0);
    }

    public function test_inactive_faq_is_visible_in_protected_preview_and_status_can_change_without_reordering(): void
    {
        $this->actingAs(User::factory()->create());
        $faq = Faq::create([
            'question' => 'Pertanyaan internal?',
            'slug' => 'pertanyaan-internal',
            'short_answer' => 'Jawaban internal.',
            'full_answer' => '<p>Penjelasan lengkap.</p>',
            'is_active' => false,
            'sort_order' => 4,
        ]);

        $this->get(route('admin.faqs.show', $faq))->assertOk()->assertSee('Penjelasan lengkap.');
        $this->patch(route('admin.faqs.status', $faq))->assertRedirect(route('admin.faqs.index'));
        $this->assertTrue($faq->fresh()->is_active);
        $this->assertSame(4, $faq->fresh()->sort_order);
        $this->patch(route('admin.faqs.status', $faq))->assertRedirect(route('admin.faqs.index'));
        $this->assertFalse($faq->fresh()->is_active);
    }

    public function test_search_status_filter_and_permanent_delete(): void
    {
        $this->actingAs(User::factory()->create());
        $active = Faq::create([
            'question' => 'Prosedur hemodialisis?',
            'slug' => 'prosedur-hemodialisis',
            'short_answer' => 'Jawaban pertama.',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        Faq::create([
            'question' => 'Makanan pasien?',
            'slug' => 'makanan-pasien',
            'short_answer' => 'Jawaban kedua.',
            'is_active' => false,
            'sort_order' => 2,
        ]);

        $this->get(route('admin.faqs.index', ['search' => 'Prosedur', 'status' => 'active']))
            ->assertOk()->assertSee($active->question)->assertDontSee('Makanan pasien?');
        $this->get(route('admin.faqs.index', ['status' => 'inactive']))
            ->assertOk()->assertSee('Makanan pasien?')->assertDontSee($active->question);

        $this->delete(route('admin.faqs.destroy', $active))->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseMissing('faqs', ['id' => $active->id]);
        $this->get(route('admin.faqs.show', $active))
            ->assertRedirect(route('admin.faqs.index'))
            ->assertSessionHas('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.');
    }

    public function test_question_and_short_answer_are_escaped_in_admin_views(): void
    {
        $this->actingAs(User::factory()->create());
        $faq = Faq::create([
            'question' => '<script>question()</script>',
            'slug' => 'faq-script',
            'short_answer' => '<img src=x onerror=alert(1)>',
            'sort_order' => 1,
        ]);

        $this->get(route('admin.faqs.index'))
            ->assertOk()
            ->assertSee('&lt;script&gt;question()&lt;/script&gt;', false)
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;', false);
        $this->get(route('admin.faqs.show', $faq))
            ->assertOk()
            ->assertSee('&lt;script&gt;question()&lt;/script&gt;', false)
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;', false);
    }

    public function test_question_without_slug_characters_uses_unique_fallback(): void
    {
        $this->actingAs(User::factory()->create());
        $payload = [
            'question' => '???',
            'short_answer' => 'Jawaban belum tersedia.',
            'is_active' => '0',
        ];

        $this->post(route('admin.faqs.store'), $payload)->assertRedirect(route('admin.faqs.index'));
        $this->post(route('admin.faqs.store'), $payload)->assertRedirect(route('admin.faqs.index'));

        $this->assertSame(['faq', 'faq-2'], Faq::ordered()->pluck('slug')->all());
    }
}
