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

    <div class="py-8 px-4 max-w-6xl mx-auto space-y-6">
        

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-800">
                    Mapa de Cobertura
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Pasa el cursor o haz clic sobre cualquier región para consultar disponibilidad.
                </p>
            </div>
            
            <div class="flex items-center gap-3 bg-white border border-slate-200 shadow-sm px-4 py-2 rounded-xl text-sm font-medium">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="text-slate-600">Valor UF Hoy:</span>
                <span class="font-bold text-emerald-600 text-base">
                    ${{ number_format($uf, 2, ',', '.') }}
                </span>
            </div>
        </div>

   
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">

         
            <div class="md:col-span-5 bg-white border border-slate-200 p-6 rounded-2xl shadow-sm flex flex-col justify-between items-center min-h-[500px]">
                <h2 class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2 w-full text-left border-b border-slate-100 pb-2">
                    Mapa Interactivo de Chile
                </h2>

       
                <div id="map" class="w-full h-full flex justify-center items-center my-auto min-h-[420px]"></div>
            </div>

            <div class="md:col-span-7 space-y-4 flex flex-col justify-between">
                <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm space-y-6 h-full">
                    <div>
                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest block">Cobertura Operacional</span>
                        <h3 class="text-2xl font-black text-slate-800 mt-1">TechSolutions Chile</h3>
                    </div>

                    <!-- Resumen de Métricas -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 border border-slate-200/80 p-4 rounded-xl">
                            <span class="text-xs text-slate-500 block font-medium">Regiones Activas</span>
                            <span class="text-lg font-extrabold text-emerald-600 mt-1 block">16 Regiones</span>
                        </div>
                        <div class="bg-slate-50 border border-slate-200/80 p-4 rounded-xl">
                            <span class="text-xs text-slate-500 block font-medium">Proyectos Asignados</span>
                            <span class="text-lg font-extrabold text-indigo-600 mt-1 block">72 Proyectos</span>
                        </div>
                    </div>

                    <div class="p-4 bg-indigo-50/70 border border        <!-- Header Claro -->-indigo-100 rounded-xl text-sm text-indigo-900">
                        <p class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-indigo-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Pasa el cursor por las regiones en el mapa para desplegar su estado de cobertura interactivo.</span>
                        </p>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 p-4 rounded-xl flex justify-between items-center text-xs font-medium text-slate-600 shadow-sm">
                    <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Cobertura Alta</span>
                    <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Cobertura Media</span>
                    <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Cobertura Baja</span>
                </div>
            </div>

        </div>

    </div>
</x-layout>