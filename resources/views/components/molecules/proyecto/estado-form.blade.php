@props([
    'proyecto',
    'estados' => [],
])

<form method="POST" action="{{ route('registro-proyecto.update', $proyecto) }}" class="flex items-center gap-2">

    @csrf

    {{-- HTML solo envia GET y POST. @method('PATCH') agrega el campo oculto _method
         que Laravel lee para redirigir la peticion al metodo correcto. --}}
    @method('PATCH')

    <x-atoms.form.select
        name="estado"
        :id="'estado-' . $proyecto->id"
        :options="$estados"
        :selected="$proyecto->estado"
        :old="false"
        placeholder="Sin estado"
        aria-label="Cambiar estado del proyecto"
        required
        onchange="this.form.submit()"
        class="w-auto! py-1 text-xs"
    />

    {{-- Si el navegador tiene JS desactivado el select no se auto-envia, este boton lo cubre --}}
    <noscript>
        <x-atoms.form.button type="submit" variant="secondary" class="px-3 py-1 text-xs">
            Cambiar
        </x-atoms.form.button>
    </noscript>
</form>

{{-- Formulario de cambio de estado, pendiente de revisión visual, requisitos:
- El id del select lleva el id del proyecto para no repetir ids en la página cuando hay varias tarjetas
- w-auto! usa el modificador de importancia de Tailwind v4 (sufijo) para ganarle al w-full del átomo
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}
