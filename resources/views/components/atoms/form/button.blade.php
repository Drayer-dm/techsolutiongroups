@props([
    'type' => 'submit',
    'variant' => 'primary',
])

@php
    $styles = $variant == 'primary'
    ? 'bg-[#10243e] text-white hover:bg-[#1a3557]'
    : 'bg-slate-100 text-slate-700 hover:bg-slate-200';
@endphp

<button
    type = " {{ $type }} "
    {{ $attributes->merge(['class'=> 'inline-flex items-center justify-center gap-1.5 px-6 rounded-md font-semibold transitions-colors {$styles} disabled:opacity-60 disabled:cursos-not-allowed']) }}>
    {{ $slot }}
</button>