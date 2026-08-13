@props([
    'label' => '',
    'valor' => '',
])

<div {{ $attributes->merge(['class' => 'min-w-0']) }}>
    <dt class="text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">
        {{ $label }}
    </dt>
    <dd class="mt-0.5 truncate text-sm text-slate-800 dark:text-slate-200">
        {{ $valor }}
    </dd>
</div>

{{-- Par etiqueta/valor de una ficha de proyecto, pendiente de revisión visual, requisitos:
- Va siempre dentro de un <dl>, no lo uses suelto
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}
