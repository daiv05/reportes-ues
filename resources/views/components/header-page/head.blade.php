<div class="mb-2 flex h-auto w-full flex-col items-start justify-center rounded-lg bg-white p-6">
    <p class="text-2xl font-bold text-escarlata-ues">{{ $tituloMenor }}</p>
    <p class="text-2xl md:text-3xl font-black text-escarlata-ues">{{ $tituloMayor }}</p>
    <p class="font-normal text-gray-500">
        {{ $subtitulo }}
    </p>
    @if (isset($acciones))
        <div class="flex flex-col justify-center md:justify-start pt-4">
            {{ $acciones }}
        </div>
    @endif
</div>
