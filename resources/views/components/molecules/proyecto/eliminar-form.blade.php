@props(['proyecto'])

<form
    method="POST"
    action="{{ route('registro-proyecto.destroy', $proyecto) }}"
    onsubmit="return confirm('Seguro que quieres eliminar este proyecto? Esta accion no se puede deshacer.')"
>
    @csrf
    @method('DELETE')

    <x-atoms.form.button type="submit" variant="danger" class="px-3 py-1 text-xs">
        Eliminar
    </x-atoms.form.button>
</form>

{{-- Formulario de eliminación, pendiente de revisión visual, requisitos:
- El texto del confirm() va fijo a propósito: interpolar el nombre del proyecto rompería
  el JavaScript del atributo si el nombre trae comillas
- Evaluar reemplazar el confirm() nativo por un modal con Alpine
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}
