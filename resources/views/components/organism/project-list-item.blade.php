@props([
'proyecto'])

<article class="flex flex-col lg:flex-row gap-8 py-10 border-b border-gray-200 last:border-0">
    <div class="lg:w-1/3">
        <h3 class="text-xl text-gray-600 font-light mb-4">{{ $proyecto['titulo'] }}</h3>
        <div class="text-sm text-gray-500 leading-relaxed">
            {{ $proyecto['descripcion']}}
        </div>
    </div>

    <div class="lg:w-2/3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
        @foreach ( $proyecto['galeria'] as $item)
        <x-molecules.others.gallery-thumbnail
        :images="$item['imagen']"
        :leyenda="$item['leyenda']"
        :link= "$item['link'] ?? null"
        />
        @endforeach
    </div>
</article>
