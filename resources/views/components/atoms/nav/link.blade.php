@props([
'href' => '#',
'active'=> false,
])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'text-sm font-medium transition-colors '
            . ($active
                ? 'text-slate-900 dark:text-white border-b-2 border-amber-500 pb-1'
                : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white')
    ]) }}
>
    {{$slot}}
</a>

{{-- Link de navegación pendiente de revisión visual, requisitos:
- Revisar el estado activo (border-b-2 border-amber-500) contra los colores institucionales de https://www.techsolution.cl/ --}}