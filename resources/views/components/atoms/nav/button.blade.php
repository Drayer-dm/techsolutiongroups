@props([
'href'=> '#',
'variant' => 'primary',
])

@php 
    $styles = $variant == 'primary'
    ?'bg-[#10243e] text-white hover:bg-[#1a3557]'
    : 'bg-slate-100 text-slate-700 hover:bg-slate-200';
@endphp

<a href="{{ $href }}" {{$atributes->merge([
    'class' => "inline-flex items-center gap-1.5 px-4 py-2 rounded-md txt-sm font-semibold transition-colors {$styles}"
    ]) }}>
    {{$slot}}
</a>

<!-- Agregamos el php para crear una variante de los botones-->

{{-- Botón de navegación pendiente de revisión, requisitos:
- BUG: la variable se llama $atributes en vez de $attributes (línea 12), por lo que el merge de clases nunca se aplica realmente; revisar antes de usar este componente
- BUG: la clase "txt-sm" no es válida en Tailwind, debería ser "text-sm"
- Este componente no se usa actualmente en ninguna vista, confirmar si sigue siendo necesario
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}