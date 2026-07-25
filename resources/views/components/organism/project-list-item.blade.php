@props(['proyecto'])

<article class="flex flex-col lg:flex-row gap-8 py-10 border-b border-slate-800/80 last:border-0">
    {{-- Columna Izquierda: Información del Proyecto --}}
    <div class="lg:w-1/3">
        <h3 class="text-xl text-white font-semibold mb-4 leading-snug">{{ $proyecto['titulo'] }}</h3>
        
        {{-- 🔒 SEGURIDAD: Renderizado de HTML crudo para procesar los saltos de línea (<br>) --}}
        <div class="text-sm text-slate-400 leading-relaxed space-y-2">
            {!! $proyecto['descripcion'] !!}
        </div>
    </div>

    {{-- Columna Derecha: Galería de imágenes --}}
    <div class="lg:w-2/3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($proyecto['galeria'] as $item)
            <x-molecules.others.gallery-thumbnail 
                :imagen="$item['imagen']" 
                :leyenda="$item['leyenda']" 
                :link="$item['link'] ?? null" 
            />
        @endforeach
    </div>
</article>