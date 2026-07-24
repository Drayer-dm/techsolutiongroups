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
    class="mb-8 rounded-lg overflow-hidden shadow-sm relative"
>
    <div class="bg-white dark:bg-slate-900 px-4 py-1 flex items-center justify-between gap-6">
        <x-atoms.nav.logo href="/" />

        <div class="flex items-center gap-2">
            {{-- toggle modo oscuro --}}
            <button
                @click="toggleDark()"
                class="p-2 rounded-md text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
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

    <div
        :class="open ? 'flex' : 'hidden'"
        class="md:flex bg-white dark:bg-slate-900 px-6 py-3 flex-col md:flex-row items-center justify-center border-t border-slate-100 dark:border-slate-800 gap-4 md:gap-8"
    >
        <x-atoms.nav.link href="{{ asset('servicios') }}" :active="request()->routeIs('servicios')">Servicios</x-atoms.nav.link>
        <x-atoms.nav.link href="{{ asset('productos') }}" :active="request()->routeIs('productos')">Productos</x-atoms.nav.link>
        <x-atoms.nav.link href="{{ asset('nosotros') }}" :active="request()->routeIs('nosotros')">Nosotros</x-atoms.nav.link>
        <x-atoms.nav.link href="{{ asset('contacto') }}" :active="request()->routeIs('contacto')">Contacto</x-atoms.nav.link>
        <x-atoms.nav.link href="{{ asset('faq') }}" :active="request()->routeIs('faq')">FAQ</x-atoms.nav.link>
        <x-atoms.nav.link href="{{ asset('cobertura') }}" :active="request()->routeIs('cobertura')">Cobertura</x-atoms.nav.link>
    </div>
</nav>
 