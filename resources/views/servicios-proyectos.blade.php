{{-- Template: Servicios --}}
<x-layout>
    <x-slot name="title">Servicios - Techsolution</x-slot>

    <!-- Indicador de Ruta (Breadcrumb) -->
    <div class="w-full flex justify-center py-6 border-b border-gray-100 mb-8">
        <p class="text-[11px] text-gray-400 font-bold tracking-widest uppercase">
            <a href="/" class="hover:text-yellow-500 transition-colors">Home</a> 
            <span class="mx-2 text-gray-300">></span> 
            <span class="text-yellow-500">Servicios</span>
        </p>
    </div>

    <!-- Contenido Principal -->
    <main class="container mx-auto max-w-5xl px-4 pb-20 flex flex-col lg:flex-row gap-12">
        
        {{-- Columna Izquierda: Detalle de Servicios (75%) --}}
        <section class="lg:w-3/4">
            <header class="mb-6">
                <h1 class="text-2xl text-gray-600 font-serif uppercase tracking-wide mb-6">Servicios</h1>
                <p class="text-sm text-gray-500 leading-relaxed mb-4">
                    Actualmente, nuestra oferta de servicios se orienta hacia el logro de soluciones integrales, prácticas, flexibles y eficientes. Según lo anterior, los servicios son agrupados en las categorías de:
                </p>
            </header>

            {{-- Lista de Servicios con Viñetas --}}
            <ul class="list-disc list-inside text-sm text-gray-500 space-y-2 pl-4 mb-6 marker:text-gray-400">
                @foreach($servicios as $servicio)
                    <li>{{ $servicio }}</li>
                @endforeach
            </ul>

            <p class="text-sm text-gray-500 leading-relaxed">
                También podemos ajustarnos a cualquier proyecto tecnológico que este dentro de nuestro alcance.
            </p>
        </section>

        {{-- Columna Derecha: Sidebar (25%) --}}
        <aside class="lg:w-1/4">
            <x-organism.sidebar-menu />
        </aside>

    </main>
    {{-- Template: Proyectos --}}
<x-layout>
    <x-slot name="title">Proyectos - Techsolution</x-slot>

    <!-- Indicador de Ruta (Breadcrumb) -->
    <div class="w-full flex justify-center py-6 border-b border-gray-100 mb-8">
        <p class="text-[11px] text-gray-400 font-bold tracking-widest uppercase">
            <a href="/" class="hover:text-yellow-500 transition-colors">Home</a> 
            <span class="mx-2 text-gray-300">></span> 
            <span class="text-yellow-500">Proyectos</span>
        </p>
    </div>

    <!-- Contenido Principal -->
    <main class="container mx-auto max-w-5xl px-4 pb-16">
        <header class="mb-4">
            <h1 class="text-2xl text-gray-600 font-serif uppercase tracking-wide">Proyectos</h1>
        </header>

        <section class="w-full">
            @foreach($proyectos as $proyecto)
                <x-organism.project-list-item :proyecto="$proyecto" />
            @endforeach
        </section>
    </main>
</x-layout>
</x-layout>