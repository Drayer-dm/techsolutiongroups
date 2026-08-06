@props([
    'type' => 'submit',
    'variant' => 'primary',
])

@php
    $styles = $variant == 'primary'
    ? 'bg-[#10243e] text-white hover:bg-[#1a3557]'
    : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-600';
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-1.5 px-6 py-2 rounded-md font-semibold transition-colors ' . $styles . ' disabled:opacity-60 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>

{{-- Botón de formulario pendiente de revisión visual, requisitos:
- El color primario está hardcodeado en hex (#10243e), evaluar moverlo a la config de Tailwind como color institucional reutilizable
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}