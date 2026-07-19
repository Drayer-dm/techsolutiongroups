@props([
    'href' => asset('images/favicon.png') . '?v=2',
    'type' => 'image/png',
    'rel' => 'icon',
])

<link rel="{{ $rel }}" type=" {{ $type }}" href=" $href">