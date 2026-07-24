<footer class="bg-slate-900 mt-10">
    <div class="footer-content grid grid-cols-1 md:grid-cols-3 gap-8 p-8">

        {{-- enlaces --}}
        <div class="footer-column">
            <h4 class="text-white font-semibold mb-2">Links de importancia</h4>
            <ul class="space-y-1">
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
        <div class="footer-column">
            <h4 class="text-white font-semibold mb-2">Contacto</h4>
            <p class="text-slate-300">Correo: contacto@techsolution.cl</p>
            <p class="text-slate-300">Fono: (+56) (9) 1234 5678</p>
        </div>

        {{-- copyright --}}
        <div class="footer-bottom col-span-full border-t border-slate-700 text-slate-400 text-sm text-center pt-4 mt-8">
            <p>Copyright © {{ date('Y') }} - Todos los derechos reservados - Techsolution.cl</p>
        </div>
    </div>
</footer>