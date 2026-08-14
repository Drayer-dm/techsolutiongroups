@props([
    'proyecto',
    'estados' => [],
])

<article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-colors hover:border-[#113f59]/40 dark:border-[#113f59] dark:bg-[#113f59]/20">

    <div class="flex items-start justify-between gap-3">
        <h3 class="font-semibold text-[#113f59] dark:text-white">{{ $proyecto->nombre }}</h3>

        <x-atoms.ui.badge :variant="$proyecto->estado" class="shrink-0">
            {{ $estados[$proyecto->estado] ?? $proyecto->estado }}
        </x-atoms.ui.badge>
    </div>

    <dl class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3">
        <x-molecules.proyecto.dato label="Responsable" :valor="$proyecto->responsable" />
        <x-molecules.proyecto.dato label="Inicio" :valor="$proyecto->fecha_inicio->format('d-m-Y')" />
        <x-molecules.proyecto.dato label="Monto" :valor="'$' . number_format($proyecto->monto, 0, ',', '.')" />
    </dl>

    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-4 dark:border-[#113f59]">
        <x-molecules.proyecto.estado-form :proyecto="$proyecto" :estados="$estados" />
        <x-molecules.proyecto.eliminar-form :proyecto="$proyecto" />
    </div>
</article>

{{-- Tarjeta de proyecto del usuario, pendiente de revisión visual, requisitos:
- No confundir con organism/project-card.blade.php, que es la tarjeta de la web pública
- fecha_inicio llega como objeto Carbon gracias al cast 'date' del modelo Proyecto
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}
