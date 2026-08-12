<header class="fixed top-4 left-0 right-0 z-50 px-4">
    <nav
        x-data="{
            open: false,
            dark: document.documentElement.classList.contains('dark'),
            toggleDark() {
                this.dark = !this.dark;
                document.documentElement.classList.toggle('dark', this.dark);
                localStorage.theme = this.dark ? 'dark' : 'light';
            },
        }"
        class="max-w-6xl mx-auto rounded-3xl bg-white/80 dark:bg-[#0d1b2a]/80 backdrop-blur-md border border-slate-200/60 dark:border-[#113f59] shadow-xl px-4 py-3 transition-all duration-300"
    >
        <div class="flex items-center justify-between">
            
            {{-- Logo institucional --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logo.webp') }}" alt="Techsolutions Logo" class="h-8 w-auto object-contain">
                <span class="font-bold text-lg text-[#113f59] dark:text-white tracking-wide">
                    Tech<span class="text-orange-500">solutions</span>
                </span>
            </a>

            {{-- Menú de escritorio estilo Píldora --}}
            <div class="hidden lg:flex items-center bg-slate-100/70 dark:bg-[#113f59]/40 px-3 py-1 rounded-full border border-slate-200/60 dark:border-[#113f59] space-x-1">
                <a href="{{ url('/') }}" class="px-3 py-1.5 rounded-full text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-white hover:bg-[#113f59] dark:hover:bg-orange-500 transition-all">Inicio</a>
                <a href="{{ asset('servicios-proyectos') }}" class="px-3 py-1.5 rounded-full text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-white hover:bg-[#113f59] dark:hover:bg-orange-500 transition-all">Servicios y Proyectos</a>
                <a href="{{ asset('productos') }}" class="px-3 py-1.5 rounded-full text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-white hover:bg-[#113f59] dark:hover:bg-orange-500 transition-all">Productos</a>
                <a href="{{ asset('nosotros') }}" class="px-3 py-1.5 rounded-full text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-white hover:bg-[#113f59] dark:hover:bg-orange-500 transition-all">Nosotros</a>
                <a href="{{ asset('cobertura') }}" class="px-3 py-1.5 rounded-full text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-white hover:bg-[#113f59] dark:hover:bg-orange-500 transition-all">Cobertura</a>
                <a href="{{ asset('faq') }}" class="px-3 py-1.5 rounded-full text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-white hover:bg-[#113f59] dark:hover:bg-orange-500 transition-all">FAQ</a>
                <a href="{{ asset('contacto') }}" class="px-4 py-1.5 rounded-full text-sm font-semibold bg-orange-500 text-white hover:bg-orange-600 shadow-sm transition-all">Contacto</a>
            </div>

            {{-- Controles Derecha (Modo Oscuro y Hamburguesa) --}}
            <div class="flex items-center gap-2">
                {{-- Toggle Modo Oscuro --}}
                <button
                    @click="toggleDark()"
                    class="p-2 rounded-full text-slate-600 dark:text-slate-300 hover:bg-slate-200/60 dark:hover:bg-[#113f59]/60 transition-colors"
                    aria-label="Cambiar tema"
                >
                    <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

            {{-- btn hamburguesa, solo visible en mobile --}}
            <button @click="open = !open" class="md:hidden p-2 text-slate-600 dark:text-slate-300" aria-label="Abrir menú">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

        {{-- Menú Desplegable para Móviles (Creado con clases puras de Tailwind CSS) --}}
        <div 
            x-show="open" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="lg:hidden mt-3 pt-3 border-t border-slate-200/60 dark:border-[#113f59] flex flex-col space-y-1"
            style="display: none;"
        >
            <a href="{{ url('/') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-[#113f59] hover:text-white dark:hover:bg-orange-500 transition-all">Inicio</a>
            <a href="{{ asset('servicios-proyectos') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-[#113f59] hover:text-white dark:hover:bg-orange-500 transition-all">Servicios y Proyectos</a>
            <a href="{{ asset('productos') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-[#113f59] hover:text-white dark:hover:bg-orange-500 transition-all">Productos</a>
            <a href="{{ asset('nosotros') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-[#113f59] hover:text-white dark:hover:bg-orange-500 transition-all">Nosotros</a>
            <a href="{{ asset('cobertura') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-[#113f59] hover:text-white dark:hover:bg-orange-500 transition-all">Cobertura</a>
            <a href="{{ asset('faq') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-[#113f59] hover:text-white dark:hover:bg-orange-500 transition-all">FAQ</a>
            <a href="{{ asset('contacto') }}" class="mt-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-center bg-orange-500 text-white hover:bg-orange-600 shadow-md transition-all">Contacto</a>
        </div>
    </nav>
</header>
{{-- La navbar debe ser diseniada nuevamente, el disenio queda a eleccion del encargado grafico, solo se piden los
siguientes requisitos:
- Ocupar solamente componentes de Tailwindcss o CSS vanilla // Esto aplica a la creacion desde 0 para el menu burguer de
la version movil
- Los colores deben ser los institucionales de la pagina original en cuestion: https://www.techsolution.cl/ --}}
 