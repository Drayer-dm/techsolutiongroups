@props ([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'id' => 1,
])

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    <x-atoms.form.label :for="$id" : required="$required">
        {{ $label }}
    </x-atoms.form.label>

    <x-atoms.form.input 
        :id="$id"
        :type ="$type"
        :name ="$name"
        :placeholder="$placeholder"
        :required="$required"
    />

    <x-atoms.form.error :name= "$name"/>
</div> 