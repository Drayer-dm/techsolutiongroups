@props(['logo', 'nombre'])

<div class="flex items-center justify-center p-4 bg-slate-800/50 border border-slate-700 rounded-xl hover:bg-slate-700/50 transition-colors duration-300 h-24">
    <img src="{{ asset($logo) }}" alt="Cliente {{ $nombre }}" class="max-h-full max-w-full object-contain filter grayscale hover:grayscale-0 transition-all duration-300" loading="lazy">
</div>

{{-- Logo de cliente pendiente de revisión visual, requisitos:
- Confirmar que el tamaño del contenedor (h-24) sea suficiente para todos los logos entregados
- IMPORTANTE: los logos de clientes deben estar en formato .webp para cumplir el estándar de imágenes del sitio
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}