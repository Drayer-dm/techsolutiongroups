<x-layout>
    <x-slot name="title">Soluciones Tecnológicas - Techsolution</x-slot>

    <div class="w-full bg-slate-900 border-b border-slate-800 pt-10 pb-16">
        <div class="container mx-auto max-w-7xl px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight">Soluciones <span
                    class="text-cyan-400">Tecnológicas</span></h1>
            <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                Integramos servicios, desarrollamos proyectos y respaldamos la continuidad operativa de tu empresa.
            </p>
        </div>
    </div>

    <main class="w-full bg-[#0B1120] pb-24">

        <section class="container mx-auto max-w-7xl px-4 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl text-white font-semibold">Nuestros Servicios</h2>
                <div class="h-1 w-20 bg-cyan-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($servicios as $servicio)
                    <div
                        class="bg-slate-800/30 border border-slate-700/50 p-6 rounded-2xl hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(6,182,212,0.1)] transition-all duration-300">
                        <div class="text-3xl mb-4">{{ $servicio['icono'] }}</div>
                        <h3 class="text-slate-200 font-medium text-base">{{ $servicio['titulo'] }}</h3>
                    </div>
                @endforeach
            </div>
        </section>


        <section class="container mx-auto max-w-7xl px-4 py-16 border-t border-slate-800/60">
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl text-white font-semibold">Proyectos Destacados</h2>
                    <div class="h-1 w-20 bg-cyan-500 mt-4 rounded-full"></div>
                </div>
                <p class="text-slate-400 text-sm max-w-md">Casos de éxito y despliegues técnicos ejecutados bajo los más
                    altos estándares de calidad de la industria.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($proyectos as $proyecto)

                    <x-organism.project-card :proyecto="$proyecto" />
                @endforeach
            </div>
        </section>

        <section class="container mx-auto max-w-7xl px-4 py-16 border-t border-slate-800/60">
            <div class="text-center mb-12">
                <h2 class="text-3xl text-white font-semibold">Clientes que confían en nosotros</h2>
                <div class="h-1 w-20 bg-cyan-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($clientes as $cliente)

                    <x-molecules.others.client-logo :logo="$cliente['logo']" :nombre="$cliente['nombre']" />
                @endforeach
            </div>
        </section>

    </main>
</x-layout>

{{-- Vista de Servicios y Proyectos pendiente de revisión visual, requisitos:
- Esta vista usa un tema oscuro fijo (bg-slate-900 / #0B1120), revisar si debe respetar el toggle de modo claro/oscuro igual que el resto del sitio
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}