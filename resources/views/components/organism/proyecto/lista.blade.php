@props([
    'proyectos',
    'estados' => [],
])

<div {{ $attributes->merge(['class' => 'space-y-4']) }}>

    @forelse ($proyectos as $proyecto)

        <x-organism.proyecto.card :proyecto="$proyecto" :estados="$estados" />

    @empty

        <div class="rounded-2xl border border-dashed border-slate-300 p-10 text-center dark:border-[#113f59]">
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Aun no tienes proyectos registrados. Usa el formulario de arriba para crear el primero.
            </p>
        </div>

    @endforelse

</div>

{{-- Listado de proyectos del usuario, pendiente de revisión visual, requisitos:
- @forelse/@empty es la versión de Blade que ya trae incorporado el caso "lista vacía"
- Cuando la lista crezca, evaluar paginación (->paginate() en el controlador)
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}
