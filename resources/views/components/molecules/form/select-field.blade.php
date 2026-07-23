@props([
'name'=>'',
'label'=> '',
'options'=> [],
'placeholder'=> 'Seleccione una opción',
'required'=> false,])

<div {{ $attributes->merge(['class'=> 'flex flex-col']) }}>
    <x-atoms.form.label :form="$name" :required="$required">
        {{ $label }}
    </x-atoms.form.label>

    <x-atoms.form.select
    :name="$name"
    :options="$options"
    :placeholder="$placeholder"
    :required="$required"
    />

    <x-atoms.form.error :name ="$name" />
</div>