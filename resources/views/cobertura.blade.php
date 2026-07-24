@php
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Cache;

    // Consumo del servicio externo para la UF
    $uf = Cache::remember('valor_uf', 43200, function () {
        try {
            $response = Http::withoutVerifying()->timeout(3)->get('https://mindicador.cl/api/uf');
            return $response->json()['serie'][0]['valor'] ?? 37800;
        } catch (\Exception $e) {
            return 37800;
        }
    });
@endphp

<x-layout>
    {{-- Carga de scripts locales de Simplemaps --}}
    <script src="{{ asset('js/mapdata.js') }}"></script>
    <script src="{{ asset('js/countrymap.js') }}"></script>

    <div class="w-full max-w-6xl mx-auto py-6 sm:py-8 px-3 sm:px-6 space-y-6 sm:space-y-8 overflow-x-hidden">
        
        <!-- Header Claro -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-800">
                    Mapa de Cobertura
                </h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">
                   Techsolution ofrece cobertura desde Arica a Pta Arenas. En las principales ciudades capitales y algunas intermedias.
                </p>
            </div>
            
            <!-- Badge UF -->
            <div class="flex items-center gap-2.5 bg-white border border-slate-200 shadow-sm px-3.5 py-2 rounded-xl text-xs sm:text-sm font-medium shrink-0">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="text-slate-600">Valor UF Hoy:</span>
                <span class="font-bold text-emerald-600 text-sm sm:text-base">
                    ${{ number_format($uf, 2, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Contenedor del Mapa e Información -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5 sm:gap-6 items-stretch w-full">

            <!-- Columna Izquierda: El Mapa Ampliado -->
            <div class="md:col-span-5 bg-white border border-slate-200 p-4 sm:p-6 rounded-2xl shadow-sm flex flex-col justify-between items-center min-h-[380px] sm:min-h-[420px] w-full overflow-hidden">
                <h2 class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2 w-full text-left border-b border-slate-100 pb-2">
                    Mapa Interactivo de Chile
                </h2>

                <!-- Div contenedor del mapa ampliado -->
                <div id="map" class="w-full h-full flex justify-center items-center my-auto min-h-[350px] sm:min-h-[420px]"></div>
            </div>

            <!-- Columna Derecha: Tarjetas de Información -->
            <div class="md:col-span-7 space-y-4 flex flex-col justify-between w-full">
                <div class="bg-white border border-slate-200 p-4 sm:p-6 rounded-2xl shadow-sm space-y-5 h-full overflow-hidden">
                    <div>
                        <span class="text-[11px] sm:text-xs font-bold text-indigo-600 uppercase tracking-widest block">Cobertura Operacional</span>
                        <h3 class="text-xl sm:text-2xl font-black text-slate-800 mt-1">TechSolutions Chile</h3>
                    </div>

                    <!-- Resumen de Métricas -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div class="bg-slate-50 border border-slate-200/80 p-3.5 sm:p-4 rounded-xl">
                            <span class="text-xs text-slate-500 block font-medium">Regiones Activas</span>
                            <span class="text-base sm:text-lg font-extrabold text-emerald-600 mt-0.5 block">16 Regiones</span>
                        </div>
                        <div class="bg-slate-50 border border-slate-200/80 p-3.5 sm:p-4 rounded-xl">
                            <span class="text-xs text-slate-500 block font-medium">Proyectos Asignados</span>
                            <span class="text-base sm:text-lg font-extrabold text-indigo-600 mt-0.5 block">0 Proyectos</span>
                        </div>
                    </div>

                    <div class="p-3.5 sm:p-4 bg-indigo-50/70 border border-indigo-100 rounded-xl text-xs sm:text-sm text-indigo-900">
                        <p class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-indigo-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Pasa el cursor por las regiones en el mapa para desplegar su estado de cobertura interactivo.</span>
                        </p>
                    </div>
                </div>

                <!-- Leyenda Corregida (Responsive total) -->
                <div class="bg-white border border-slate-200 p-3.5 sm:p-4 rounded-xl grid grid-cols-3 gap-2 text-center sm:text-left sm:flex sm:justify-between items-center text-xs font-medium text-slate-600 shadow-sm overflow-hidden">
                    <span class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span> <span class="leading-tight">Cobertura Alta</span></span>
                    <span class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></span> <span class="leading-tight">Cobertura Media</span></span>
                    <span class="flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 shrink-0"></span> <span class="leading-tight">Cobertura Baja</span></span>
                </div>
            </div>

        </div>

        <!-- SECCIÓN INFERIOR EN TARJETAS RESPONSIVAS -->
        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 pt-4 border-t border-slate-200">
            
            <!-- Bloque 1: Datos de Contacto -->
            <div class="bg-white border border-slate-200 p-4 sm:p-6 rounded-2xl shadow-sm flex flex-col justify-between w-full overflow-hidden">
                <div>
                    <span class="text-[11px] sm:text-xs font-bold text-indigo-600 uppercase tracking-wider block mb-1">Información Directa</span>
                    <h3 class="text-base font-extrabold text-slate-800 border-b border-slate-100 pb-2 mb-3 sm:mb-4">
                        Datos de Contacto
                    </h3>
                    
                    <div class="space-y-3.5 sm:space-y-4 text-xs text-slate-600">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-slate-50 border border-slate-100 rounded-lg text-indigo-600 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="break-words min-w-0">
                                <strong class="block text-slate-800 font-bold">Puerto Montt</strong>
                                <span>Papa León XIII nº 2318, Portal Puerto Montt, X Región.</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-slate-50 border border-slate-100 rounded-lg text-indigo-600 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="break-words min-w-0">
                                <strong class="block text-slate-800 font-bold">Santiago</strong>
                                <span>Apoquindo 6410 OF 606, Las Condes.</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-slate-50 border border-slate-100 rounded-lg text-indigo-600 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <span class="font-bold text-slate-800 break-all">(+56) (9) 8401 0588</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-slate-50 border border-slate-100 rounded-lg text-indigo-600 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="font-bold text-slate-800 break-all">contacto@techsolution.cl</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bloque 2: Mapa de Sitio -->
            <div class="bg-white border border-slate-200 p-4 sm:p-6 rounded-2xl shadow-sm w-full overflow-hidden">
                <span class="text-[11px] sm:text-xs font-bold text-indigo-600 uppercase tracking-wider block mb-1">Navegación</span>
                <h3 class="text-base font-extrabold text-slate-800 border-b border-slate-100 pb-2 mb-3 sm:mb-4">
                    Mapa de Sitio
                </h3>
                
                <div class="grid grid-cols-2 gap-2.5 text-xs font-medium">
                    <a href="#" class="text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span> Home
                    </a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span> Productos
                    </a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span> Nosotros
                    </a>
                    <a href="#" class="text-indigo-600 font-bold flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 shrink-0"></span> Cobertura
                    </a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span> Servicios
                    </a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span> Contacto
                    </a>
                </div>
            </div>

            <!-- Bloque 3: Boletín Integrado -->
            <div class="bg-slate-900 border border-slate-800 p-4 sm:p-6 rounded-2xl shadow-sm text-white w-full flex flex-col justify-between overflow-hidden md:col-span-2 lg:col-span-1">
                <div>
                    <span class="text-[11px] sm:text-xs font-bold text-indigo-400 uppercase tracking-wider block mb-1">Novedades</span>
                    <h3 class="text-base font-extrabold border-b border-slate-800 pb-2 mb-3">
                        Suscríbete al Boletín
                    </h3>
                    <p class="text-slate-400 text-xs mb-3">
                        Recibe actualizaciones periódicas sobre la cobertura de nuestros servicios.
                    </p>

                    <form class="space-y-2.5" action="#" method="POST">
                        @csrf
                        <input type="text" placeholder="Nombres y Apellidos" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        
                        <input type="email" placeholder="Tu correo electrónico" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-xs text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        
                        <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs uppercase tracking-wider rounded-lg transition-all mt-1">
                            Suscribirme
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Pie de página final -->
        <div class="pt-3 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center text-[11px] sm:text-xs text-slate-500 gap-1.5 font-medium text-center sm:text-left">
            <p>© {{ date('Y') }} Techsolution.cl. Todos los derechos reservados.</p>
            <p class="text-slate-400">Diseñado por Techsolution.cl</p>
        </div>

    </div>
</x-layout>