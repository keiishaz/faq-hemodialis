<footer class="border-t border-[#C6DED1] bg-sage">
    <div class="mx-auto w-full max-w-5xl px-5 py-8 sm:px-8 sm:py-10">
        <p class="max-w-3xl text-base leading-relaxed text-ink">
            Informasi pada halaman ini bersifat edukasi umum dan tidak menggantikan konsultasi dengan dokter atau tenaga kesehatan.
        </p>
        <div class="mt-6 border-t border-[#BED7CA] pt-5 text-sm leading-relaxed text-hospital-deep sm:flex sm:items-center sm:justify-between sm:gap-6">
            <p class="font-semibold">{{ config('hospital.name') }}</p>
            @if (config('hospital.contact'))
                <p class="mt-2 sm:mt-0">Kontak: {{ config('hospital.contact') }}</p>
            @endif
        </div>
    </div>
</footer>
