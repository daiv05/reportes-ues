<div class="mb-2 flex h-auto w-full flex-col items-start justify-center rounded-lg bg-white p-6">
    <p class="text-2xl font-bold text-escarlata-ues">{{ $tituloMenor }}</p>
    <p class="text-2xl font-black text-escarlata-ues md:text-3xl">{{ $tituloMayor }}</p>
    <p class="mb-3 mt-2 font-normal text-gray-500">
        {{ $subtitulo }}
    </p>
    @if (isset($acciones))
        <div class="flex flex-wrap justify-center gap-2 pt-4 md:justify-start">
            {{ $acciones }}
        </div>
    @endif
</div>
