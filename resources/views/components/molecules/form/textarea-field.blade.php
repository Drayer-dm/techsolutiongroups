@props([
'name' => '',
'label'=> '',
'placeholder' => '',
'rows' => 10,
'required'=> false,
])

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    <x-atoms.form.label : for="$name" : required="required">
        {{ $label }}
    </x-atoms.form.label>

    <x-atoms.form.textarea
        :name = "$name"
        :placeholder ="$placeholder"
        :rows="$rows"
        :required ="$required"
    />

    <x-atoms.form.error :name="$name"/>
</div>