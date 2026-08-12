<footer class="bg-[#0d1b2a] dark:bg-slate-950 border-t border-[#113f59]/60 text-slate-300 mt-10 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            <!-- Enlaces de importancia -->
            <div>
                <h4 class="text-white font-semibold text-base mb-4 tracking-wide">
                    Links de <span class="text-orange-500">importancia</span>
                </h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ url('/') }}" class="text-slate-400 hover:text-orange-500 transition-colors">Inicio</a>
                    </li>
                    <li>
                        <a href="{{ url('/nosotros') }}" class="text-slate-400 hover:text-orange-500 transition-colors">Nosotros</a>
                    </li>
                    <li>
                        <a href="{{ url('/faq') }}" class="text-slate-400 hover:text-orange-500 transition-colors">FAQ</a>
                    </li>
                    <li>
                        <a href="{{ url('/contacto') }}" class="text-slate-400 hover:text-orange-500 transition-colors">Contacto</a>
                    </li>
                </ul>
            </div>

            <!-- Contacto Clickeable -->
            <div>
                <h4 class="text-white font-semibold text-base mb-4 tracking-wide">Contacto</h4>
                <div class="space-y-2.5 text-slate-400">
                    <p>
                        Correo: 
                        <a href="mailto:contacto@techsolution.cl" class="text-slate-200 hover:text-orange-500 underline transition-colors ml-1">
                            contacto@techsolution.cl
                        </a>
                    </p>
                    <p>
                        Fono: 
                        <a href="tel:+56912345678" class="text-slate-200 hover:text-orange-500 underline transition-colors ml-1">
                            (+56) (9) 1234 5678
                        </a>
                    </p>
                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="border-t border-[#113f59]/60 text-slate-500 text-sm text-center pt-6 mt-10">
            <p>Copyright © {{ date('Y') }} - Todos los derechos reservados - Techsolution.cl</p>
        </div>
    </div>
</footer>

{{-- Footer pendiente de rediseño, requisitos:
- Ocupar solamente componentes de Tailwindcss o CSS vanilla, respetando los colores institucionales de https://www.techsolution.cl/
- IMPORTANTE: el correo y el teléfono del bloque "Contacto" deben quedar clickeables. Agregar <a href="mailto:contacto@techsolution.cl"> al correo y <a href="tel:+56912345678"> al teléfono, para que redirijan a la app de correo o al marcador telefónico según corresponda
- Revisar que el diseño responda correctamente en mobile (actualmente el grid pasa a 1 columna bajo md) --}}