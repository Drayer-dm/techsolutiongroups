@props([
    'name' => '',
    'id' => null,
    'label' => '',
    'placeholder' => '',
    'rows' => 10,
    'required' => false,
])

@php
    $inputId = $id ?? $name;
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col w-full']) }}>
    <x-atoms.form.label :for="$inputId" :required="$required">
        {{ $label }}
    </x-atoms.form.label>

    <x-atoms.form.textarea
        :id="$inputId"
        :name="$name"
        :placeholder="$placeholder"
        :rows="$rows"
        :required="$required"
    />

    <x-atoms.form.error :name="$name" />
</div>