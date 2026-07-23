@props([
    'name' => '',
    'id' => null,
    'placeholder' => '',
    'rows' => 10,
    'required' => false,
])


@php
    $inputID = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<textarea
    name = " {{ $name }} "
    id = " {{ $inputID }} "
    rows = " {{ $rows }} "
    placeholder = " {{ $placeholder }}"
        @if($required)
            required 
        @endif
    {{ $attributes->merge([
        'class' => 'w-full rounded-md border px-4 py-2 text-sm text-slate-800 placeholder:text-slate-400 transition-colors resize-none focus:outline-none focus:ring-2 focus:ring-[#10243e]/30 focus:border-[#10243e] '
            . ($hasError ? 'border-red-400' : 'border-slate-300')]) }}
>
    {{ old($name) }}
</textarea>