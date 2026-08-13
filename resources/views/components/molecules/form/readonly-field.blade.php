@props([
    'label' => '',
    'valor' => '',
    'ayuda' => '',
])

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>

    {{-- Va un <span> y no un <label>: esto no es un control de formulario,
         es informacion. Un label sin campo asociado confunde a los lectores de pantalla. --}}
    <span class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
        {{ $label }}
    </span>

    <div class="w-full rounded-md border border-slate-300 bg-slate-50 px-4 py-2 text-sm text-slate-600 dark:border-slate-600 dark:bg-slate-800/50 dark:text-slate-400">
        {{ $valor }}
    </div>

    @if ($ayuda)
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $ayuda }}</p>
    @endif
</div>

{{-- Campo de solo lectura (etiqueta + valor fijo), pendiente de revisión visual, requisitos:
- No envía nada al servidor a propósito: es para valores que asigna el backend
- Debe leerse claramente distinto de un input editable
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}
