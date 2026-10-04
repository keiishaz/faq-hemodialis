<footer class="border-t border-[#C9DEE8] bg-[#E8F1F5] text-hospital-deep">
    <div class="public-footer-inner mx-auto w-full max-w-7xl px-5 py-8 sm:px-8 sm:py-9 lg:px-10">
        <div class="grid gap-7 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-start sm:gap-12">
            <div class="flex items-center gap-4">
                <span class="flex size-13 shrink-0 items-center justify-center rounded-xl bg-white p-1.5">
                    <img src="{{ asset('images/rsud-m-yunus-logo.png') }}" alt="" width="44" height="44" class="size-full object-contain" aria-hidden="true">
                </span>
                <div class="leading-snug">
                    <p class="text-base font-semibold">{{ config('hospital.name') }}</p>
                    <p class="mt-1 text-sm text-[#456175]">FAQ Hemodialisis</p>
                </div>
            </div>
            <address class="border-l-2 border-[#5EB7DC] pl-4 text-sm not-italic leading-relaxed sm:justify-self-end">
                <p class="font-medium text-hospital-deep">Kontak rumah sakit</p>
                <p class="mt-1 text-[#456175]">Jl. Bhayangkara, Kota Bengkulu</p>
                <p class="text-[#456175]">Telepon: {{ config('hospital.contact') ?: '(0736) 52004' }}</p>
            </address>
        </div>
        <p class="mt-7 border-t border-[#C7DBE5] pt-5 text-sm leading-relaxed text-[#456175]">
            Informasi pada halaman ini bersifat edukasi umum dan tidak menggantikan konsultasi dengan dokter atau tenaga kesehatan.
        </p>
    </div>
</footer>
