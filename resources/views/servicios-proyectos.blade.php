<x-layout>
    <x-slot name="title">Servicios y Proyectos - Techsolution</x-slot>

    <!-- Header / Breadcrumb integrado al tema oscuro -->
    <div class="w-full border-b border-slate-800 bg-slate-900/40">
        <div class="container mx-auto max-w-6xl px-4 py-4 flex justify-center lg:justify-start">
            <p class="text-[11px] text-slate-500 font-bold tracking-widest uppercase">
                <a href="/" class="hover:text-cyan-400 transition-colors">Home</a> 
                <span class="mx-2 text-slate-700">&gt;</span> 
                <span class="text-cyan-400">Servicios y Proyectos</span>
            </p>
        </div>
    </div>

    <!-- Contenido Principal -->
    <main class="container mx-auto max-w-6xl px-4 py-12 flex flex-col lg:flex-row gap-12">
        
        {{-- Columna Principal (75%) --}}
        <section class="lg:w-3/4">
            
            {{-- SECCIÓN SERVICIOS --}}
            <header class="mb-8 border-b border-slate-800 pb-6">
                <h1 class="text-3xl text-white font-bold tracking-wide mb-4">Nuestros Servicios</h1>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Actualmente, nuestra oferta de servicios se orienta hacia el logro de soluciones integrales, prácticas, flexibles y eficientes. Según lo anterior, los servicios son agrupados en las categorías de:
                </p>
            </header>

            <ul class="list-none space-y-3 mb-8 ml-2">
                @foreach($servicios as $servicio)
                    <li class="flex items-start text-sm text-slate-300">
                        <span class="text-cyan-500 mr-3 mt-0.5 text-[10px]">■</span>
                        {{ $servicio }}
                    </li>
                @endforeach
            </ul>

            <p class="text-sm text-slate-400 leading-relaxed mb-16">
                También podemos ajustarnos a cualquier proyecto tecnológico que esté dentro de nuestro alcance.
            </p>

            {{-- SECCIÓN PROYECTOS --}}
            <header class="mb-8 border-t border-slate-800 pt-10">
                <h2 class="text-2xl text-white font-bold tracking-wide mb-2">Proyectos Destacados</h2>
                <p class="text-sm text-slate-400 leading-relaxed">
                    A continuación, un portafolio de nuestros trabajos más recientes.
                </p>
            </header>

            <div class="w-full space-y-2">
                @forelse($proyectos as $proyecto)
                    <x-organism.project-list-item :proyecto="$proyecto" />
                @empty
                    <p class="text-slate-500 py-8">No hay proyectos disponibles en este momento.</p>
                @endforelse
            </div>

        </section>

    </main>
</x-layout>