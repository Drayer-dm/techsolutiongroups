@props([
    'src' => asset('images/logo.png'),
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