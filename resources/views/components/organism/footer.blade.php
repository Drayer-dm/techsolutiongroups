<footer class="bg-slate-900 mt-10">
    <div class="max-w-7xl mx-auto px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            {{-- enlaces --}}
            <div>
                <h4 class="text-white font-semibold mb-3">Links de importancia</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ url('/') }}" class="text-slate-300 hover:text-white">Inicio</a>
                    </li>
                    <li>
                        <a href="{{ url('/nosotros') }}" class="text-slate-300 hover:text-white">Nosotros</a>
                    </li>
                    <li>
                        <a href="{{ url('/faq') }}" class="text-slate-300 hover:text-white">FAQ</a>
                    </li>
                    <li>
                        <a href="{{ url('/contacto') }}" class="text-slate-300 hover:text-white">Contacto</a>
                    </li>
                </ul>
            </div>

            {{-- contacto --}}
            <div>
                <h4 class="text-white font-semibold mb-3">Contacto</h4>
                <p class="text-slate-300">Correo: contacto@techsolution.cl</p>
                <p class="text-slate-300">Fono: (+56) (9) 1234 5678</p>
            </div>

        </div>

        {{-- copyright --}}
        <div class="border-t border-slate-700 text-slate-400 text-sm text-center pt-4 mt-8">
            <p>Copyright © {{ date('Y') }} - Todos los derechos reservados - Techsolution.cl</p>
        </div>
    </div>
</footer>

{{-- Footer pendiente de rediseño, requisitos:
- Ocupar solamente componentes de Tailwindcss o CSS vanilla, respetando los colores institucionales de https://www.techsolution.cl/
- IMPORTANTE: el correo y el teléfono del bloque "Contacto" deben quedar clickeables. Agregar <a href="mailto:contacto@techsolution.cl"> al correo y <a href="tel:+56912345678"> al teléfono, para que redirijan a la app de correo o al marcador telefónico según corresponda
- Revisar que el diseño responda correctamente en mobile (actualmente el grid pasa a 1 columna bajo md) --}}