@props ([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
])

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    <x-atoms.form.label :for="$name" : required="$required">
        {{ $label }}
    </x-atoms.form.label>

    <x-atoms.form.input
    :type ="$type"
    :name ="$name"
    :placeholder="$placeholder"
    :required="$required">
    />

    <x-atoms.form.error :name= "$name"/>
</div> 