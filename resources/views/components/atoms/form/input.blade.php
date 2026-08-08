@props([
    'type' => 'text',
    'name' => '',
    'id' => null,
    'placeholder' => '',
    'value' => '',
    'required' => false,
])

@php 
    $inputID = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $inputID }}"
    placeholder="{{ $placeholder }}"
    value="{{ $type === 'password' ? '' : old($name, $value) }}"
    @if($required)
        required
    @endif
    {{ $attributes->merge(['class' => 'w-full rounded-md border px-4 py-2 text-sm text-slate-800 dark:text-slate-100 dark:bg-slate-800 placeholder:text-slate-400 dark:placeholder:text-slate-500 transition-colors focus:outline-none focus:ring focus:ring-2 focus:ring-[#10243e]/30 focus:border-[#10243e] '
    . ($hasError ? 'border-red-400' : 'border-slate-300 dark:border-slate-600')]) }}
/>

<!-- $id ?? $name: si no le pasas un id explícito, usa el name (así el for del label calza automático).
$errors->has($name): $errors es una variable que Laravel comparte automáticamente en todas las vistas después de una validación fallida. Si el campo tiene error, el borde se pinta rojo.
old($name, $value): si el usuario ya envió el formulario y falló la validación, recupera lo que había escrito, en vez de dejar el campo vacío.
-->

{{-- Input de formulario pendiente de revisión visual, requisitos:
- El color de foco (ring/border) está hardcodeado en hex (#10243e), evaluar moverlo a la config de Tailwind
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}