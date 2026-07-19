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
<a/>

<!-- Agregamos el php para crear una variante de los botones-->