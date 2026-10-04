@extends('layouts.admin')

@section('title', 'Pratinjau FAQ')

@section('content')
    <div>
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-[1.625rem] font-semibold tracking-tight text-hospital-deep">Pratinjau FAQ</p>
            </div>
            <a href="{{ route('admin.faqs.index') }}" class="inline-flex min-h-10 items-center rounded-lg border border-[#D6E5EE] bg-white px-4 text-sm font-medium text-hospital-deep hover:bg-sage focus-visible:outline-3 focus-visible:outline-hospital">Kembali ke daftar FAQ</a>
        </div>

        <div class="mt-6 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-[#B9D9E8] bg-sage px-5 py-4">
            <div class="flex items-start gap-3">
                <span class="admin-icon {{ $faq->is_active ? 'admin-icon-active' : 'admin-icon-hide' }} mt-0.5 text-hospital" aria-hidden="true"></span>
                <div>
                <p class="text-sm font-semibold text-hospital-deep">{{ $faq->is_active ? 'Konten ini tampil di halaman publik' : 'Konten ini belum tampil di halaman publik' }}</p>
                </div>
            </div>
            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $faq->is_active ? 'bg-[#E7F6EE] text-[#176247]' : 'bg-[#EBF0F4] text-[#52697B]' }}">{{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}</span>
        </div>

        <article class="mt-6 rounded-xl border border-[#D6E5EE] bg-white p-5 sm:p-6">
            <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                <p class="font-semibold text-hospital">Pratinjau admin</p>
                <p class="text-[#52697B]">Diperbarui {{ $faq->updated_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
            </div>
            <h1 class="mt-5 text-2xl font-semibold leading-tight tracking-tight text-hospital-deep">{{ $faq->question }}</h1>
            <h2 class="mt-6 text-sm font-semibold uppercase tracking-[0.05em] text-hospital">Jawaban singkat</h2>
            <p class="mt-2 whitespace-pre-line text-base leading-relaxed">{{ $faq->short_answer }}</p>
            @if ($safeFullAnswer)
                <h2 class="mt-7 text-sm font-semibold uppercase tracking-[0.05em] text-hospital">Jawaban lengkap</h2>
                <div class="faq-content mt-2 text-base leading-relaxed">{!! $safeFullAnswer !!}</div>
            @endif
            <p class="mt-8 border-t border-[#D6E5EE] pt-5 text-sm leading-relaxed text-[#52697B]">Informasi pada halaman ini bersifat edukasi umum dan tidak menggantikan konsultasi dengan dokter atau tenaga kesehatan.</p>
        </article>
        <div class="mt-6 text-right">
            <a href="{{ route('admin.faqs.edit', $faq) }}" class="inline-flex min-h-11 items-center gap-2 rounded-lg bg-hospital px-5 text-sm font-semibold text-white hover:bg-hospital-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-hospital"><span class="admin-icon admin-icon-edit !size-4" aria-hidden="true"></span>Edit FAQ</a>
        </div>
    </div>
@endsection
