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

</x-layout>