@props(['imagen', 'leyenda', 'link' => null])

<div class="flex flex-col items-start w-full group">
    <!-- 🔒 UX: Contenedor con aspecto cuadrado para un grid uniforme en el tema oscuro -->
    <div class="w-full aspect-square border border-slate-700 bg-slate-800/50 p-2 rounded-lg shadow-sm mb-3 overflow-hidden transition-all duration-300 group-hover:border-cyan-500/50 group-hover:shadow-cyan-500/10">
        <!-- 🔒 CORE: Uso de asset() asegurando la carga dinámica -->
        <img 
            src="{{ asset($imagen) }}" 
            alt="{{ $leyenda }}" 
            class="w-full h-full object-cover rounded-md transition-transform duration-500 group-hover:scale-105" 
            loading="lazy"
        >
    </div>
    
    <p class="text-[13px] text-slate-300 leading-tight font-medium">{{ $leyenda }}</p>
    
    @if($link)
        <!-- 🔒 SEGURIDAD: rel="noopener noreferrer" para enlaces externos -->
        <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="text-[13px] text-cyan-400 hover:text-cyan-300 font-semibold mt-1 transition-colors flex items-center gap-1">
            Ver sitio web <span aria-hidden="true">&raquo;</span>
        </a>
    @endif
</div>