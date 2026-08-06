@props([
    'for' => null,
    'required' => false,
])

<label for="{{ $for ?? $attributes->get('for') }}" {{ $attributes->except('for')->merge(['class' => 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1']) }}>
    {{ $slot }}
    @if($required)
        <span class="text-red-500">*</span>
    @endif
</label>

{{-- Label de formulario pendiente de revisión visual, requisitos:
- Revisar tamaño y color del asterisco de campo requerido en modo oscuro
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}