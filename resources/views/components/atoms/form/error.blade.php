@props(['name'])

@error($name)
    <p {{ $attributes->merge(['class' => 'mt-1 text-xs text-red-600']) }}>
        {{ $message }}
    </p>
@enderror

{{-- Mensaje de error de formulario pendiente de revisión visual, requisitos:
- Revisar contraste del texto de error en modo oscuro
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}