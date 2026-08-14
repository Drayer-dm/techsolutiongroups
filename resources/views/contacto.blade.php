<x-layout>
    <x-slot:title>Contacto y Cobertura - Techsolutions</x-slot:title>

    <main class="w-full bg-slate-50 dark:bg-[#0d1b2a] pt-32 pb-20 transition-colors duration-300">
        <section class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <!-- Encabezado de la sección -->
            <div class="text-center md:text-left mb-12">
                <h1 class="text-3xl sm:text-4xl font-bold text-[#113f59] dark:text-white tracking-tight">
                    Sucursales y <span class="text-orange-500">Contacto</span>
                </h1>
                <!-- Línea divisoria naranja institucional -->
                <div class="h-1 w-20 bg-orange-500 mt-3 mx-auto md:mx-0 rounded-full"></div>
                <p class="mt-4 text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-2xl">
                    Encuentra nuestras oficinas en la X Región de Los Lagos o envíanos un mensaje para brindarte soporte técnico especializado.
                </p>
            </div>

            <!-- Contenedor Principal: Información y Mapa lado a lado -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                
                <!-- Columna Izquierda: Listado de Direcciones y Formulario -->
                <div class="space-y-6">
                    <!-- Tarjeta de Direcciones -->
                    <div class="bg-white dark:bg-[#113f59]/40 border border-slate-200 dark:border-[#113f59] rounded-2xl p-6 sm:p-8 shadow-sm transition-colors duration-300">
                        <h2 class="text-xl font-semibold text-[#113f59] dark:text-white mb-4">Nuestras Oficinas en Puerto Montt</h2>
                        
                        <div class="space-y-4 text-slate-600 dark:text-slate-300 text-sm sm:text-base">
                            <!-- Ubicación 1 -->
                            <div class="flex items-start gap-3">
                                <div class="bg-orange-500/10 p-2.5 rounded-xl text-orange-500 mt-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <strong class="text-[#113f59] dark:text-white block font-medium">Portal Puerto Montt</strong>
                                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                                        Papa León XIII n° 2318, Portal Puerto Montt, Puerto Montt, X Región de Los Lagos, Chile
                                    </p>
                                </div>
                            </div>

                            <hr class="border-slate-200 dark:border-slate-700 my-3">

                            <!-- Ubicación 2 -->
                            <div class="flex items-start gap-3">
                                <div class="bg-orange-500/10 p-2.5 rounded-xl text-orange-500 mt-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <strong class="text-[#113f59] dark:text-white block font-medium">Alerce Sur</strong>
                                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                                        Gaspar Bohle 1000, Alerce Sur, Puerto Montt, X Región de Los Lagos, Chile
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de Contacto -->
                    <div class="bg-white dark:bg-[#113f59]/40 border border-slate-200 dark:border-[#113f59] rounded-2xl p-6 sm:p-8 shadow-sm transition-colors duration-300">
                        <h2 class="text-xl font-semibold text-[#113f59] dark:text-white mb-4">Envíanos un mensaje</h2>
                        <x-organism.contact-form />
                    </div>
                </div>

                <!-- Columna Derecha: Mapa de Google Maps optimizado -->
                <div class="h-full min-h-[450px] lg:min-h-[600px] bg-white dark:bg-[#113f59]/40 border border-slate-200 dark:border-[#113f59] rounded-2xl overflow-hidden shadow-sm flex flex-col">
                    <div class="p-4 bg-slate-100 dark:bg-[#113f59] border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                        <span class="text-sm font-medium text-[#113f59] dark:text-white">Ubicación de Sucursales</span>
                        <a href="https://www.google.com/maps/search/?api=1&query=Papa+Leon+XIII+2318+Puerto+Montt" target="_blank" class="text-xs text-orange-500 hover:underline font-medium">Ampliar mapa</a>
                    </div>
                    <div class="w-full flex-grow relative">
                        <iframe 
                            class="w-full h-full absolute inset-0 border-0 filter dark:contrast-125 dark:opacity-90" 
                            src="https://maps.google.com/maps?q=Papa%20Leon%20XIII%202318%2C%20Portal%20Puerto%20Montt%2C%20Puerto%20Montt+OR+Gaspar%20Bohle%201000%2C%20Alerce%20Sur%2C%20Puerto%20Montt&t=&z=12&ie=UTF8&iwloc=&output=embed" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

            </div>
        </section>
    </main>
</x-layout>

{{-- Vista de contacto pendiente de revisión visual, requisitos:
- Ocupar solamente componentes de Tailwindcss o CSS vanilla
- Revisar espaciados y tamaños de texto en mobile vs desktop
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}