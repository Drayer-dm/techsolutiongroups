@props(['proyecto'])


<article
    class="bg-slate-800/40 border border-slate-700/60 rounded-2xl overflow-hidden hover:border-cyan-500/30 transition-colors duration-300 flex flex-col h-full">
    <div class="p-6 md:p-8 flex-grow flex flex-col">

        <h3 class="text-xl text-white font-semibold mb-3">{{ $proyecto['titulo'] }}</h3>
        <p class="text-sm text-slate-400 leading-relaxed mb-6 flex-grow">
            {!! $proyecto['descripcion'] !!}
        </p>
        <div class="grid grid-cols-3 gap-3 mt-auto">
            @foreach($proyecto['galeria'] as $item)
                <div class="group relative aspect-square overflow-hidden rounded-lg bg-slate-900 border border-slate-700">
                    <img src="{{ asset($item['imagen']) }}" alt="{{ $item['leyenda'] }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                        loading="lazy">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-2">
                        <span
                            class="text-[10px] sm:text-xs text-white font-medium text-center truncate">{{ $item['leyenda'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</article>