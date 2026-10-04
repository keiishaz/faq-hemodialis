<?php

namespace Tests\Feature;

use App\Models\Faq;
use Database\Seeders\FaqSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FaqDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_initial_questions_are_inactive_and_reseeding_preserves_edits(): void
    {
        $this->seed(FaqSeeder::class);

        $this->assertSame(9, Faq::count());
        $this->assertSame(0, Faq::active()->count());
        $this->assertSame(0, Faq::whereNotNull('full_answer')->count());
        $this->assertSame(9, Faq::where('short_answer', 'Jawaban belum tersedia.')->count());

        $faq = Faq::ordered()->firstOrFail();
        $faq->update([
            'question' => 'Pertanyaan yang telah diperbarui pengelola',
            'short_answer' => 'Konten yang telah diperbarui pengelola.',
            'is_active' => true,
        ]);

        $this->seed(FaqSeeder::class);

        $this->assertSame(9, Faq::count());
        $this->assertSame('Pertanyaan yang telah diperbarui pengelola', $faq->fresh()->question);
        $this->assertSame('Konten yang telah diperbarui pengelola.', $faq->fresh()->short_answer);
        $this->assertTrue($faq->fresh()->is_active);
    }

    public function test_active_scope_and_ordered_scope_use_order_then_id(): void
    {
        $first = Faq::create([
            'question' => 'Pertanyaan pertama?',
            'slug' => 'pertanyaan-pertama',
            'short_answer' => 'Jawaban pertama.',
            'is_active' => true,
            'sort_order' => 2,
        ]);
        $second = Faq::create([
            'question' => 'Pertanyaan kedua?',
            'slug' => 'pertanyaan-kedua',
            'short_answer' => 'Jawaban kedua.',
            'is_active' => true,
            'sort_order' => 2,
        ]);
        Faq::create([
            'question' => 'Pertanyaan nonaktif?',
            'slug' => 'pertanyaan-nonaktif',
            'short_answer' => 'Jawaban nonaktif.',
            'is_active' => false,
            'sort_order' => 1,
        ]);

        $this->assertSame([$first->id, $second->id], Faq::active()->ordered()->pluck('id')->all());
        $this->assertIsInt($first->fresh()->sort_order);
    }

    public function test_schema_defaults_and_unique_slug_are_enforced(): void
    {
        $this->assertFalse(Schema::hasColumn('users', 'email_verified_at'));
        $this->assertFalse(Schema::hasTable('password_reset_tokens'));

        $faq = Faq::create([
            'question' => 'Pertanyaan contoh?',
            'slug' => 'pertanyaan-contoh',
            'short_answer' => 'Jawaban contoh.',
        ]);

        $this->assertTrue($faq->fresh()->is_active);
        $this->assertSame(0, $faq->fresh()->sort_order);

        $this->expectException(QueryException::class);

        Faq::create([
            'question' => 'Pertanyaan duplikat?',
            'slug' => 'pertanyaan-contoh',
            'short_answer' => 'Jawaban duplikat.',
        ]);
    }
}
