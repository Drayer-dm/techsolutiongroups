@props([
    'for' => null,
    'required' => false,
    'id'=> 1,
])

<label for="{{$id}}" {{$attributes->merge(['class' => 'block text-sm font-medium text-slate-700 mb-1'])}}>
    {{$slot}}
    @if($required)
    <span class="text-red-500">*</span>
    @endif
</label>