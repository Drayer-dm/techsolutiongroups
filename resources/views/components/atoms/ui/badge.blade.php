@props([
    'variant' => 'neutral',
])

@php
    $styles = match ($variant) {
        'pendiente'  => 'bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300',
        'en_curso'   => 'bg-sky-100 text-sky-800 dark:bg-sky-500/15 dark:text-sky-300',
        'finalizado' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/15 dark:text-emerald-300',
        'cancelado'  => 'bg-red-100 text-red-800 dark:bg-red-500/15 dark:text-red-300',
        default      => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ' . $styles]) }}>
    {{ $slot }}
</span>

{{-- Badge de estado pendiente de revisión visual, requisitos:
- Los colores salen de la paleta por defecto de Tailwind, ajustar a los institucionales de https://www.techsolution.cl/
- El átomo no depende de Proyecto ni de rutas: recibe una variante y un texto, nada más --}}
