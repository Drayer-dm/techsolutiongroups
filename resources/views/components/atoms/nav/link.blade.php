@prop([
'href' => '#'
'active'=> false,
])

<a href="{{ $href }}" {{ $atributes->merge([
    'class' => 'text-sm font-medium transition-colors'. ($active
    ? 'text-slate-900 border-b-2 border-amber-500 pb-1'
    : 'text-slate-600 hover:text-slate-900')
    ]) }}>
    {{$slot}}
    <a/>
<!-- alo-->