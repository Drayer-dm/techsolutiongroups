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
            <h4 class="font-bold text-xl mb-2"></h4>
            <p>soy un servicio ~ camaras</p>
        </div>

        {{-- card 2 --}}
        <div class="border rounded-lg p-6 shadow-sm">
            <h4 class="font-bold text-xl mb-2"></h4>
            <p>soy un servicio</p>
        </div>

        {{-- card 3 --}}
        <div class="border rounded-lg p-6 shadow-sm">
            <h4 class="font-bold text-xl mb-2"></h4>
            <p>soy un servicio</p>
        </div>

        {{-- card 4 --}}
        <div class="border rounded-lg p-6 shadow-sm">
            <h4 class="font-bold text-xl mb-2"></h4>
            <p>soy un servicio</p>
        </div>
    </div>

</x-layout>