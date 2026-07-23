@props([
    'name' => '',
    'id' => null,
    'options' => [],
    'placeholder' => 'Seleccione una opcion',
    'required' => false,
])


@php 
    $inputID = $id ?? $name;
    $hasError = $errors->($name);
    $selected = old($name);
@endphp

<select 
    name = " {{ $name }} "
    id = " {{ $inputID }} "
    @if($required)
        required 
    @endif
    {{ $attributes->merge ([
    'class' => 'w-full rounded-md px-4 py-2 text-sm text-slate-800 bg-white transition-colors focus:outline-none focus:ring-2 focus:ring-[#10243e]/30 focus:border-[10243e]'
    .($hasError ? 'border-red-400' : 'border-slate-300') ]) }}>

    <option value="" @selected(!$selected)>{{ $placeholder }}</option>
    @foreach ($option as $value =>$text)
        <option value="" {{ $value }} @selecte
        d($selected == $value)> {{ $text }}</option>
    @endforeach
</select>

<!--$options agarra un array valor = texto.value osea recibe el valor en texto y al momento de enviar el valor envia el name ="asunto"

el @selected(...) es directiva de blade que agrega el atributo selected osea ya esta seleccionado, aplique que mientras la opcion sea verdadera quede marcada, gracias al old($name)-->