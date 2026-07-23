<x-layout>
    <x-slot:title>Servicio informático Puerto Montt ~ Desarrollo Web Puerto Montt</x-slot:title>

    {{-- maquetado de la pagina --}}

    {{-- hero-banner --}}
    <div class="hero relative w-full h-[600px] overflow-hidden">

        {{-- imgan del hero--}}
        <img src="{{ asset('images/hero-banner.png')}}" 
            alt="racs_banner"
            class="absolute inset-0 w-full h-full object-cover">

        {{-- textos del hero ~ contneido --}}    
        <div class="contenido-banner relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Techsolutions</h1>
            <p class="text-lg md:text-xl max-w-2x1">Ofrecemos cobertura para la zona sur del pais</p>
        </div>

    </div>

    {{-- Contenido texto & cards --}}
    <div class="content-container mt-16 md:mt-24 text-center">
        <h3 class="font-bold text-3xl">Nuestros servicios</h3>
        <p class="mt-4">En Techsolutions ofrecemos una gama de servicios enfocados en el area informatica.</p>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
        {{-- cards --}}

        {{-- card 1 --}}
        <div class="border rounded-lg p-6 shadow-sm">
            <x-atoms.icon.camara class="w-10 h-10 mx-auto text-gray-700" />
            <h4 class="font-bold text-xl mb-2">
                Camaras de seguridad
            </h4>
            <p>
                Ofrecemos instalacines de camaras de seguridad mediante
                rigurosos estandares de la industria.
            </p>
        </div>

        {{-- card 2 --}}
        <div class="border rounded-lg p-6 shadow-sm">
            <x-atoms.icon.cable class="w-10 h-10 mx-auto text-gray-700" />
            <h4 class="font-bold text-xl mb-2">Cableados Corporativos</h4>
            <p>
                Contamos con servicios de instalacion de cableado con fines de uso
                corporativo
            </p>
        </div>

        {{-- card 3 --}}
        <div class="border rounded-lg p-6 shadow-sm">
            <x-atoms.icon.tuerca class="w-10 h-10 mx-auto text-gray-700" />
            <h4 class="font-bold text-xl mb-2">Cableado Industrial</h4>
            <p>
                Contamos con cableado industrial, enfocado en el sector
                IT para manejo de servidores
            </p>
        </div>

        {{-- card 4 --}}
        <div class="border rounded-lg p-6 shadow-sm">
            <x-atoms.icon.program class="w-10 h-10 mx-auto text-gray-700" />
            <h4 class="font-bold text-xl mb-2">Servicios de IT</h4>
            <p>
                Ofrecemos servicios informaticos enfocados en area de programacion,
                 manejo de servidores y mas.
            </p>
        </div>
    </div>
    {{-- ceo info --}}
    <div class="mt-4 text-center w-full bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 py-12 px-6 rounded-2x1 shadow-lg">
        <h3 class="font-bold text-xl mb-2 text-white">CEO - Juanito Pecados</h4>
        <img src="{{ asset('images/the_ceo.jpg') }}" 
        alt="the_ceo"
        class="w-40 h-40 object-cover rounded-full mx-auto mb-4 border-4  border-cyan-400/60 shadow[0_0_20px_rgba(34,211,238,0.4)]">
        <h4 class="text-cyan-300 font-medium">
            Ingeniero en informatica con multiples menciones en el area IT, doctorado en ciencia de datos, 
            ex-ingeniero aeroespacial con colaboraciones en la NASA
        </h4>
        <p class="text-slate-200 max-w-2x1 mx-auto mt-2">
            Contamos con un equipo capacitado dentro del area de IT siempre entregando la mejor experiencia
            a nuestros clientes mediante la ejecucion de proyectos de manera eficaz y eficiente.
        </p>
    </div>
</x-layout>