@props([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'id' => 1,
])

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    <x-atoms.form.label :for="$id" :required="$required">
        {{ $label }}
    </x-atoms.form.label>

    <x-atoms.form.input 
        :id="$id"
        :type="$type"
        :name="$name"
        :placeholder="$placeholder"
        :required="$required"
    />

    <x-atoms.form.error :name="$name" />
</div>

{{-- Campo de formulario (label + input + error) pendiente de revisión visual, requisitos:
- El prop "id" tiene un valor por defecto numérico (1), revisar que no genere ids duplicados si se usa más de un <x-molecules.form.field> sin id explícito
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}