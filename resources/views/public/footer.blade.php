<footer class="border-t border-[#DCEAF1] bg-white">
    <div class="mx-auto w-full max-w-7xl px-5 py-8 sm:px-8 sm:py-10 lg:px-12">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/rsud-m-yunus-logo.png') }}" alt="" width="44" height="44" class="size-11 shrink-0 object-contain" aria-hidden="true">
                <div class="text-sm leading-relaxed text-hospital-deep">
                    <p class="font-bold">{{ config('hospital.name') }}</p>
                    @if (config('hospital.contact'))
                        <p>Kontak: {{ config('hospital.contact') }}</p>
                    @endif
                </div>
            </div>
            <p class="max-w-xl border-l-4 border-[#8FCFE8] pl-4 text-sm leading-relaxed text-[#405E72]">
                Informasi pada halaman ini bersifat edukasi umum dan tidak menggantikan konsultasi dengan dokter atau tenaga kesehatan.
            </p>
        </div>
    </div>
</footer>
