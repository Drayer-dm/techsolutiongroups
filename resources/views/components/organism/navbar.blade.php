<nav x-data="{ open: false }" class="mb-8 rounded-lg overflow-hidden shadow-sm relative">
    <div class="bg-[#fff] px-4 py-1 flex items-center justify-between gap-6">
        <x-atoms.nav.logo href="/" />

        {{-- btn hamburguesa, solo visible en mobile --}}
        <button @click="open = !open" class="md:hidden p-2" aria-label="Abrir menú">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div
        :class="open ? 'flex' : 'hidden'"
        class="md:flex bg-white px-6 py-3 flex-col md:flex-row items-center justify-between border-t border-slate-100 gap-4 md:gap-0"
    >
        <x-atoms.nav.link href="{{ asset('servicios') }}" :active="request()->routeIs('servicios')">Servicios</x-atoms.nav.link>
        <x-atoms.nav.link href="{{ asset('productos') }}" :active="request()->routeIs('productos')">Productos</x-atoms.nav.link>
        <x-atoms.nav.link href="{{ asset('nosotros') }}" :active="request()->routeIs('nosotros')">Nosotros</x-atoms.nav.link>
        <x-atoms.nav.link href="{{ asset('contacto') }}" :active="request()->routeIs('contacto')">Contacto</x-atoms.nav.link>
        <x-atoms.nav.link href="{{ asset('faq') }}" :active="request()->routeIs('faq')">FAQ</x-atoms.nav.link>
        <x-atoms.nav.link href="{{ asset('cobertura') }}" :active="request()->routeIs('cobertura')">Cobertura</x-atoms.nav.link>
    </div>
</nav>
 