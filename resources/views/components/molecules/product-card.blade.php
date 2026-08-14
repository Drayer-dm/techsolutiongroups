@props(['producto'])

@props(['producto'])

{{-- Contenedor adaptable: añadimos tabindex="0", cursor-pointer, outline-none y focus-within --}}
<div tabindex="0" class="group relative bg-white dark:bg-[#113f59]/30 border border-slate-200 dark:border-[#113f59] rounded-2xl overflow-hidden shadow-sm transition-all duration-300 hover:shadow-xl focus-within:shadow-xl h-[360px] w-full cursor-pointer outline-none">
    
    {{-- CAPA SUPERIOR (Face 1) --}}
    {{-- Añadimos group-focus-within:-translate-y-28 y group-focus:-translate-y-28 --}}
    <div class="absolute inset-0 z-20 bg-white dark:bg-[#0d1b2a] transition-all duration-500 ease-in-out group-hover:-translate-y-28 group-focus:-translate-y-28 group-focus-within:-translate-y-28 flex flex-col items-center justify-center p-4 sm:p-6">
        
        <div class="w-24 h-24 mb-4 bg-orange-100 dark:bg-orange-900/20 rounded-full flex items-center justify-center overflow-hidden border-2 border-orange-500/20">
            <img src="{{ asset('images/productos/' . $producto['imagen']) }}" alt="{{ $producto['nombre'] }}" class="w-full h-full object-cover">
        </div>
        
        <h3 class="font-bold text-lg sm:text-xl text-[#113f59] dark:text-white text-center">{{ $producto['nombre'] }}</h3>
        <p class="text-orange-500 font-bold text-base sm:text-lg mt-1">${{ number_format($producto['precio'], 0, ',', '.') }}</p>
        
        {{-- Añadimos group-focus:opacity-100 y group-focus-within:opacity-100 --}}
        <p class="hidden md:block text-[10px] uppercase tracking-widest text-slate-400 mt-4 opacity-0 group-hover:opacity-100 group-focus:opacity-100 group-focus-within:opacity-100 transition-opacity duration-300">
            Ver detalles
        </p>
    </div>

    {{-- CAPA INFERIOR (Face 2) --}}
    {{-- Añadimos group-focus:translate-y-0 y group-focus-within:translate-y-0 --}}
    <div class="absolute inset-x-0 bottom-0 z-10 h-32 bg-slate-50 dark:bg-[#113f59]/50 p-4 sm:p-6 flex flex-col justify-between translate-y-full group-hover:translate-y-0 group-focus:translate-y-0 group-focus-within:translate-y-0 transition-transform duration-500 ease-in-out border-t border-slate-200 dark:border-[#113f59]">
        <div>
            <h4 class="font-bold text-sm text-[#113f59] dark:text-white line-clamp-1">{{ $producto['nombre'] }}</h4>
            <p class="text-slate-600 dark:text-slate-300 text-xs mt-1 line-clamp-2">{{ $producto['descripcion'] }}</p>
        </div>

        <button type="button" 
            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 rounded-lg shadow-sm transition-all flex items-center justify-center gap-2 text-xs uppercase tracking-wide">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Agregar
        </button>
    </div>
</div>

{{-- Card de producto pendiente de rediseño, requisitos:
- El botón "Agregar al carrito" es solo visual, aún no tiene lógica asociada
- IMPORTANTE: las imágenes en images/productos/ deben estar en formato .webp para cumplir el estándar de imágenes del sitio
- Revisar estados hover/focus y colores institucionales de https://www.techsolution.cl/ --}}