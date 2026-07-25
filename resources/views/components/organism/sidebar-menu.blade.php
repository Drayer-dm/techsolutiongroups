{{-- 
    Organism: Sidebar Menu
    Menú lateral derecho que aparece en la vista de Servicios.
--}}
<aside class="w-full">
    <h3 class="text-lg text-gray-600 font-serif border-b border-gray-200 pb-2 mb-4">MENÚ</h3>
    <nav class="flex flex-col text-sm text-gray-500">
        <ul class="space-y-0">
            <li class="border-b border-gray-100 py-1.5 hover:text-yellow-500 transition-colors">
                <a href="/" class="flex items-center gap-2"><span class="text-gray-300 text-xs">»</span> Home</a>
            </li>
            <li class="border-b border-gray-100 py-1.5">
                <a href="/nosotros" class="flex items-center gap-2 hover:text-yellow-500 transition-colors"><span class="text-gray-300 text-xs">»</span> Nosotros</a>
                <ul class="pl-4 mt-1 space-y-0">
                    <li class="border-b border-gray-100 py-1.5 hover:text-yellow-500 transition-colors">
                        <a href="#" class="flex items-center gap-2"><span class="text-gray-300 text-xs">»</span> Clientes</a>
                    </li>
                    <li class="border-b border-gray-100 py-1.5 hover:text-yellow-500 transition-colors">
                        <a href="/faq" class="flex items-center gap-2"><span class="text-gray-300 text-xs">»</span> Preguntas Frecuentes</a>
                    </li>
                </ul>
            </li>
            <li class="border-b border-gray-100 py-1.5 hover:text-yellow-500 transition-colors">
                <a href="{{ route('servicios-proyectos.index') }}" class="flex items-center gap-2"><span class="text-gray-300 text-xs">»</span> Servicios</a>
            </li>
            <li class="border-b border-gray-100 py-1.5 hover:text-yellow-500 transition-colors">
                <a href="/cobertura" class="flex items-center gap-2"><span class="text-gray-300 text-xs">»</span> Cobertura</a>
            </li>
            <li class="py-1.5 hover:text-yellow-500 transition-colors">
                <a href="/contacto" class="flex items-center gap-2"><span class="text-gray-300 text-xs">»</span> Contacto</a>
            </li>
        </ul>
    </nav>
</aside>