@props([
    'name' => '',
    'id' => null,
    'placeholder' => '',
    'rows' => 10,
    'required' => false,
])

@php
    $inputId = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<textarea
    name="{{ $name }}"
    id="{{ $inputId }}"
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    @if($required)
        required
    @endif
    {{ $attributes->merge([
        'class' => 'w-full rounded-md border px-4 py-2 text-sm text-slate-800 dark:text-slate-100 dark:bg-slate-800 placeholder:text-slate-400 dark:placeholder:text-slate-500 transition-colors resize-none focus:outline-none focus:ring-2 focus:ring-[#10243e]/30 focus:border-[#10243e] '
            . ($hasError ? 'border-red-400' : 'border-slate-300 dark:border-slate-600')
    ]) }}
>{{ old($name) }}</textarea>

{{-- Textarea de formulario pendiente de revisión visual, requisitos:
- Mantener resize-none o evaluar si el nuevo diseño permite resize vertical
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}