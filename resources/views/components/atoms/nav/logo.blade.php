@props([
    'src' => asset('/images/logo.webp'),
    'alt' => 'Tech Solutions',
    'href' => '/',
])
<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'flex items-center gap-2 group']) }}
>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="h-9 w-auto transition-opacity group-hover:opacity-80">
    @else
        <span class="text-xl font-bold tracking-tight text-white">
            {{ $slot->isEmpty() ? $alt : $slot }}
        </span>
    @endif
</a>

{{-- Logo de navegación pendiente de revisión visual, requisitos:
- Confirmar que images/logo.webp sea el logo institucional final en alta resolución
- IMPORTANTE: images/logo.webp está en formato WEBP, se debe convertir a .webp para cumplir el estándar de imágenes del sitio
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}