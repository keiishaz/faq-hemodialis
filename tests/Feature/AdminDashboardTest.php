<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_dashboard_shows_zero_counts_and_one_add_action(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('totalFaqs', 0)
            ->assertViewHas('activeFaqs', 0)
            ->assertViewHas('inactiveFaqs', 0)
            ->assertSee('Belum ada FAQ.')
            ->assertSee('Tambah FAQ');
    }

    public function test_dashboard_counts_database_records_and_shows_only_five_latest_updates(): void
    {
        $this->actingAs(User::factory()->create());
        $faqs = [];

        for ($number = 1; $number <= 6; $number++) {
            $faq = Faq::query()->create([
                'question' => 'Pertanyaan '.$number.'?',
                'slug' => 'pertanyaan-'.$number,
                'short_answer' => 'Jawaban belum tersedia.',
                'is_active' => $number <= 4,
                'sort_order' => $number,
            ]);
            DB::table('faqs')->where('id', $faq->id)->update([
                'updated_at' => now()->subMinutes(6 - $number),
            ]);
            $faqs[] = $faq;
        }

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('totalFaqs', 6)
            ->assertViewHas('activeFaqs', 4)
            ->assertViewHas('inactiveFaqs', 2)
            ->assertViewHas('recentFaqs', fn ($recent) => $recent->pluck('id')->all() === [
                $faqs[5]->id,
                $faqs[4]->id,
                $faqs[3]->id,
                $faqs[2]->id,
                $faqs[1]->id,
            ])
            ->assertDontSee('Pertanyaan 1?');
    }
}
