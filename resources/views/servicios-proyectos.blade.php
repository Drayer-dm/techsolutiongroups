{{-- 
    Template: Servicios y Proyectos
    Combina ambas vistas integrando la lista de servicios arriba y el loop de proyectos debajo.
--}}
<x-layout>
    <x-slot name="title">Servicios y Proyectos - Techsolution</x-slot>

    <!-- Indicador de Ruta (Breadcrumb) -->
    <div class="w-full flex justify-center py-6 border-b border-gray-100 mb-8">
        <p class="text-[11px] text-gray-400 font-bold tracking-widest uppercase">
            <a href="/" class="hover:text-yellow-500 transition-colors">Home</a> 
            <span class="mx-2 text-gray-300">></span> 
            <span class="text-yellow-500">Servicios y Proyectos</span>
        </p>
    </div>

    <!-- Contenido Principal -->
    <main class="container mx-auto max-w-6xl px-4 pb-20 flex flex-col lg:flex-row gap-12">
        
        {{-- Columna Izquierda: Servicios y Proyectos (75%) --}}
        <section class="lg:w-3/4">
            
            {{-- BLOQUE 1: SERVICIOS --}}
            <header class="mb-6">
                <h1 class="text-2xl text-gray-600 font-serif uppercase tracking-wide mb-6">Servicios</h1>
                <p class="text-sm text-gray-500 leading-relaxed mb-4">
                    Actualmente, nuestra oferta de servicios se orienta hacia el logro de soluciones integrales, prácticas, flexibles y eficientes. Según lo anterior, los servicios son agrupados en las categorías de:
                </p>
            </header>

            <ul class="list-disc list-inside text-sm text-gray-500 space-y-2 pl-4 mb-6 marker:text-gray-400">
                @foreach($servicios as $servicio)
                    <li>{{ $servicio }}</li>
                @endforeach
            </ul>

            <p class="text-sm text-gray-500 leading-relaxed mb-16">
                También podemos ajustarnos a cualquier proyecto tecnológico que este dentro de nuestro alcance.
            </p>

            {{-- BLOQUE 2: PROYECTOS --}}
            <header class="mb-8 border-t border-gray-200 pt-10">
                <h2 class="text-2xl text-gray-600 font-serif uppercase tracking-wide mb-2">Proyectos</h2>
                <p class="text-sm text-gray-500 leading-relaxed">
                    A continuación, un portafolio de nuestros trabajos más recientes.
                </p>
            </header>

            <div class="w-full space-y-6">
                @foreach($proyectos as $proyecto)
                    {{-- 🔒 REUTILIZACIÓN: Usamos el componente Organism que creamos anteriormente --}}
                    <x-organism.project-list-item :proyecto="$proyecto" />
                @endforeach
            </div>

        </section>

        {{-- Columna Derecha: Sidebar (25%) --}}
        <aside class="lg:w-1/4">
            <x-organism.sidebar-menu />
        </aside>

    </main>
</x-layout>