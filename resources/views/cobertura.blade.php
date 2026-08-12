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
    <x-slot:title>Cobertura - TechSolutions</x-slot:title>

    <main class="w-full bg-slate-50 dark:bg-[#0d1b2a] pt-32 pb-24 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Cabecera de la sección -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-200 dark:border-[#113f59] pb-5">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-[#113f59] dark:text-white">
                        Mapa de Cobertura
                    </h1>
                    <div class="h-1 w-67 bg-orange-500 mt-2 rounded-full"></div>
                    <p class="text-slate-600 dark:text-slate-300 text-sm mt-2">
                        Pasa el cursor o haz clic sobre cualquier región para consultar disponibilidad.
                    </p>
                </div>
                
                <div class="flex items-center gap-3 bg-white dark:bg-[#113f59]/40 border border-slate-200 dark:border-[#113f59] shadow-sm px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-300">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-orange-500"></span>
                    </span>
                    <span class="text-slate-600 dark:text-slate-300">Valor UF Hoy:</span>
                    <span class="font-bold text-orange-600 dark:text-orange-400 text-base">
                        ${{ number_format($uf, 2, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">

                <!-- Contenedor del Mapa Interactivo -->
                <div class="md:col-span-5 bg-white dark:bg-[#113f59]/30 border border-slate-200 dark:border-[#113f59] p-6 rounded-2xl shadow-sm flex flex-col justify-between items-center min-h-[500px] transition-colors duration-300">
                    <h2 class="text-xs font-bold text-orange-500 uppercase tracking-wider mb-2 w-full text-left border-b border-slate-100 dark:border-[#113f59] pb-2">
                        Mapa Interactivo de Chile
                    </h2>

                    <div id="map" class="w-full h-full flex justify-center items-center my-auto min-h-[420px]"></div>
                </div>

                <!-- Panel Lateral de Métricas e Información -->
                <div class="md:col-span-7 space-y-4 flex flex-col justify-between">
                    <div class="bg-white dark:bg-[#113f59]/30 border border-slate-200 dark:border-[#113f59] p-6 rounded-2xl shadow-sm space-y-6 h-full transition-colors duration-300">
                        <div>
                            <span class="text-xs font-bold text-orange-500 uppercase tracking-widest block">Cobertura Operacional</span>
                            <h3 class="text-2xl font-black text-[#113f59] dark:text-white mt-1">TechSolutions Chile</h3>
                        </div>

                        <!-- Resumen de Métricas -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 dark:bg-[#113f59]/40 border border-slate-200/80 dark:border-[#113f59] p-4 rounded-xl transition-colors duration-300">
                                <span class="text-xs text-slate-500 dark:text-slate-300 block font-medium">Regiones Activas</span>
                                <span class="text-lg font-extrabold text-orange-500 mt-1 block">16 Regiones</span>
                            </div>
                            <div class="bg-slate-50 dark:bg-[#113f59]/40 border border-slate-200/80 dark:border-[#113f59] p-4 rounded-xl transition-colors duration-300">
                                <span class="text-xs text-slate-500 dark:text-slate-300 block font-medium">Proyectos Asignados</span>
                                <span class="text-lg font-extrabold text-[#113f59] dark:text-orange-400 mt-1 block">72 Proyectos</span>
                            </div>
                        </div>

                        <!-- Cuadro de Aviso -->
                        <div class="p-4 bg-orange-500/10 border border-orange-500/20 rounded-xl text-sm text-[#113f59] dark:text-slate-200 transition-colors duration-300">
                            <p class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-orange-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Pasa el cursor por las regiones en el mapa para desplegar su estado de cobertura interactivo.</span>
                            </p>
                        </div>
                    </div>

                    <!-- Leyenda del Mapa -->
                    <div class="bg-white dark:bg-[#113f59]/30 border border-slate-200 dark:border-[#113f59] p-4 rounded-xl flex justify-between items-center text-xs font-medium text-slate-600 dark:text-slate-300 shadow-sm transition-colors duration-300">
                        <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Cobertura Alta</span>
                        <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Cobertura Media</span>
                        <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Cobertura Baja</span>
                    </div>
                </div>

            </div>

        </div>
    </main>

    {{-- Carga de scripts locales de Simplemaps (única instancia al final) --}}
    <script src="{{ asset('js/mapdata.js') }}"></script>
    <script src="{{ asset('js/countrymap.js') }}"></script>
</x-layout>