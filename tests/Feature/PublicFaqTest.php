<?php

namespace Tests\Feature;

use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFaqTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_list_contains_only_active_faqs_in_stable_order(): void
    {
        Faq::create([
            'question' => 'Pertanyaan kedua?',
            'slug' => 'pertanyaan-kedua',
            'short_answer' => 'Jawaban kedua.',
            'is_active' => true,
            'sort_order' => 2,
        ]);
        Faq::create([
            'question' => 'Pertanyaan tersembunyi?',
            'slug' => 'pertanyaan-tersembunyi',
            'short_answer' => 'Jawaban tersembunyi.',
            'full_answer' => '<p>Isi draft.</p>',
            'is_active' => false,
            'sort_order' => 1,
        ]);
        Faq::create([
            'question' => 'Pertanyaan pertama?',
            'slug' => 'pertanyaan-pertama',
            'short_answer' => 'Jawaban pertama.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->get(route('public.index'))
            ->assertOk()
            ->assertSeeInOrder(['Pertanyaan pertama?', 'Pertanyaan kedua?'])
            ->assertDontSee('Pertanyaan tersembunyi?')
            ->assertDontSee('Jawaban tersembunyi.')
            ->assertDontSee('Isi draft.')
            ->assertSee('Informasi pada halaman ini bersifat edukasi umum dan tidak menggantikan konsultasi dengan dokter atau tenaga kesehatan.')
            ->assertDontSee('Lihat Selengkapnya');
    }

    public function test_detail_requires_active_faq_with_meaningful_full_answer(): void
    {
        $activeFaq = Faq::create([
            'question' => 'Pertanyaan aktif?',
            'slug' => 'pertanyaan-aktif',
            'short_answer' => 'Jawaban singkat yang berbeda.',
            'full_answer' => '<p>Jawaban <strong>lengkap</strong>.</p><script>alert(1)</script><a href="javascript:alert(1)" onclick="alert(1)">Tautan</a>',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        $emptyFaq = Faq::create([
            'question' => 'Pertanyaan kosong?',
            'slug' => 'pertanyaan-kosong',
            'short_answer' => 'Jawaban singkat.',
            'full_answer' => '<p>&nbsp;<br></p>',
            'is_active' => true,
            'sort_order' => 2,
        ]);
        $inactiveFaq = Faq::create([
            'question' => 'Pertanyaan draft?',
            'slug' => 'pertanyaan-draft',
            'short_answer' => 'Jawaban draft.',
            'full_answer' => '<p>Jawaban rahasia.</p>',
            'is_active' => false,
            'sort_order' => 3,
        ]);

        $this->get(route('public.index'))
            ->assertSee(route('public.faq.show', $activeFaq->slug))
            ->assertDontSee(route('public.faq.show', $emptyFaq->slug))
            ->assertDontSee('Jawaban rahasia.');

        $this->get(route('public.faq.show', $activeFaq->slug))
            ->assertOk()
            ->assertSee('<strong>lengkap</strong>', false)
            ->assertDontSee('Jawaban singkat yang berbeda.')
            ->assertDontSee('alert(1)')
            ->assertDontSee('onclick=', false)
            ->assertDontSee('javascript:', false)
            ->assertSee('Kembali ke FAQ')
            ->assertSee('Informasi pada halaman ini bersifat edukasi umum dan tidak menggantikan konsultasi dengan dokter atau tenaga kesehatan.');

        foreach ([$emptyFaq->slug, $inactiveFaq->slug, 'tidak-ada'] as $slug) {
            $this->get(route('public.faq.show', $slug))
                ->assertNotFound()
                ->assertSee('FAQ tidak ditemukan')
                ->assertSee('Kembali ke FAQ')
                ->assertDontSee('Jawaban rahasia.');
        }
    }

    public function test_empty_public_list_shows_guidance_without_drafts(): void
    {
        Faq::create([
            'question' => 'Pertanyaan belum aktif?',
            'slug' => 'pertanyaan-belum-aktif',
            'short_answer' => 'Jawaban belum tersedia.',
            'is_active' => false,
            'sort_order' => 1,
        ]);

        $this->get(route('public.index'))
            ->assertOk()
            ->assertSee('Informasi belum tersedia. Silakan hubungi petugas.')
            ->assertDontSee('Pertanyaan belum aktif?')
            ->assertDontSee('Jawaban belum tersedia.')
            ->assertDontSee('Kontak:');
    }
}
