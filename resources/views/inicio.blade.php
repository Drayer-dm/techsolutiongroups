<x-layout>
    <x-slot:title>Servicio informático Puerto Montt ~ Desarrollo Web Puerto Montt</x-slot:title>

    <main class="w-full bg-slate-50 dark:bg-[#0d1b2a] pb-20 transition-colors duration-300">
        
        {{-- Hero Banner Responsivo Corregido --}}
        <div class="hero relative w-full h-[320px] sm:h-[420px] md:h-[550px] overflow-hidden shadow-lg">
            <img src="{{ asset('/images/hero-banner.webp') }}" 
                alt="racs_banner"
                class="absolute inset-0 w-full h-full object-cover brightness-90">
            
            {{-- Capa de superposición con tono institucional para mejorar contraste --}}
            <div class="absolute inset-0 bg-[#113f59]/50 dark:bg-[#0d1b2a]/70"></div>
            
            <div class="contenido-banner relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
                <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold tracking-tight mb-3">
                    Tech<span class="text-orange-500">solutions</span>
                </h1>
                <div class="h-1 bg-orange-500 mb-4 rounded-full"></div>
                <p class="text-sm sm:text-lg md:text-xl max-w-2xl text-slate-100">
                    Ofrecemos servicios tecnológicos de alto rendimiento alrededor del país
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Contenido texto & cards --}}
            <div class="content-container mt-16 md:mt-24 text-center">
                <h3 class="font-bold text-3xl text-[#113f59] dark:text-white">Nuestros servicios</h3>
                <div class="h-1 w-70 bg-orange-500 mt-3 mx-auto rounded-full"></div>
                <p class="mt-4 text-slate-600 dark:text-slate-300">En Techsolutions ofrecemos una gama de servicios enfocados en el área informática.</p>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                {{-- Card 1: Cámaras de seguridad (Icono Heroicons: Video Camera) --}}
                <div class="bg-white dark:bg-[#113f59]/30 border border-slate-200 dark:border-[#113f59] rounded-2xl p-6 shadow-sm transition-all duration-300 hover:border-orange-500/50 hover:-translate-y-1">
                    <div class="bg-orange-500/10 p-3 rounded-xl inline-block mb-3 text-orange-500">
                        <svg class="w-8 h-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-xl mb-2 text-[#113f59] dark:text-white">
                        Cámaras de seguridad
                    </h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">
                        Ofrecemos instalaciones de cámaras de seguridad mediante rigurosos estándares de la industria.
                    </p>
                </div>

                {{-- Card 2: Cableados Corporativos (Icono Heroicons: Network / Server / Cube) --}}
                <div class="bg-white dark:bg-[#113f59]/30 border border-slate-200 dark:border-[#113f59] rounded-2xl p-6 shadow-sm transition-all duration-300 hover:border-orange-500/50 hover:-translate-y-1">
                    <div class="bg-orange-500/10 p-3 rounded-xl inline-block mb-3 text-orange-500">
                        <svg class="w-8 h-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-xl mb-2 text-[#113f59] dark:text-white">Cableados Corporativos</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">
                        Contamos con servicios de instalación de cableado con fines de uso corporativo.
                    </p>
                </div>

                {{-- Card 3: Cableado Industrial (Icono Heroicons: Wrench / Adjustments) --}}
                <div class="bg-white dark:bg-[#113f59]/30 border border-slate-200 dark:border-[#113f59] rounded-2xl p-6 shadow-sm transition-all duration-300 hover:border-orange-500/50 hover:-translate-y-1">
                    <div class="bg-orange-500/10 p-3 rounded-xl inline-block mb-3 text-orange-500">
                        <svg class="w-8 h-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-xl mb-2 text-[#113f59] dark:text-white">Cableado Industrial</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">
                        Contamos con cableado industrial, enfocado en el sector IT para manejo de servidores.
                    </p>
                </div>

                {{-- Card 4: Servicios de IT (Icono Heroicons: Code / CommandLine) --}}
                <div class="bg-white dark:bg-[#113f59]/30 border border-slate-200 dark:border-[#113f59] rounded-2xl p-6 shadow-sm transition-all duration-300 hover:border-orange-500/50 hover:-translate-y-1">
                    <div class="bg-orange-500/10 p-3 rounded-xl inline-block mb-3 text-orange-500">
                        <svg class="w-8 h-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-xl mb-2 text-[#113f59] dark:text-white">Servicios de IT</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300">
                        Ofrecemos servicios informáticos enfocados en área de programación, manejo de servidores y más.
                    </p>
                </div>
            </div>

            {{-- Sección CEO adaptada con la nueva paleta --}}
            <div class="mt-16 text-center w-full bg-white dark:bg-[#113f59]/30 py-12 px-6 rounded-2xl shadow-sm border border-slate-200 dark:border-[#113f59] transition-colors duration-300">
                <h3 class="font-bold text-2xl mb-1 text-[#113f59] dark:text-white">CEO - Juanito Pecados</h3>
                <p class="text-xs uppercase tracking-wider text-orange-500 font-semibold mb-6">Liderazgo y Experiencia</p>
                
                <img src="{{ asset('images/the_ceo.webp') }}"
                alt="the_ceo"
                class="w-40 h-40 object-cover rounded-full mx-auto mb-4 border-4 border-orange-500/60 shadow-md">
                
                <h4 class="text-[#113f59] dark:text-slate-200 font-medium max-w-3xl mx-auto text-sm sm:text-base">
                    Ingeniero en informática con múltiples menciones en el área IT, doctorado en ciencia de datos, ex-ingeniero aeroespacial con colaboraciones en la NASA
                </h4>
                
                <p class="text-slate-600 dark:text-slate-300 max-w-2xl mx-auto mt-3 text-sm sm:text-base">
                    Contamos con un equipo capacitado dentro del área de IT siempre entregando la mejor experiencia a nuestros clientes mediante la ejecución de proyectos de manera eficaz y eficiente.
                </p>
            </div>
        </div>
    </main>
</x-layout>

{{-- Vista de inicio pendiente de revisión visual, requisitos:
- Revisar el hero banner en mobile (altura fija h-[600px] puede no ser adecuada en pantallas pequeñas)
- La sección "CEO" tiene datos de ejemplo (nombre y foto), reemplazar por información real antes de publicar
- IMPORTANTE: images/hero-banner.png e images/the_ceo.jpg deben convertirse a .webp para cumplir el estándar de imágenes del sitio
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}