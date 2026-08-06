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

{{-- Campo select (label + select + error) pendiente de revisión visual, requisitos:
- BUG: se le pasa :form="$name" al label en vez de :for="$name" (línea 9), por lo que el atributo "for" del label no queda asociado al select; revisar antes de rediseñar
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}