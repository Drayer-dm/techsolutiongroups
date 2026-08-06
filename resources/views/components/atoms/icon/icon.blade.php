@props([
    'href' => asset('images/favicon.png') . '?v=2',
    'type' => 'image/png',
    'rel' => 'icon',
])

<link rel="{{ $rel }}" type="{{ $type }}" href="{{ $href }}">

{{-- Favicon pendiente de revisión, requisitos:
- IMPORTANTE: images/favicon.png está en formato PNG, se debe convertir a .webp para cumplir el estándar de imágenes del sitio (y actualizar el default "href" y el "type" a image/webp) --}}