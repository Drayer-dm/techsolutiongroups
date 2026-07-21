<nav class=" mb-8 rounded-lg overflow-hidden shadow-sm">
    <div class="bg-[#fff] px-4 py-1 flex items-center gap-6">
        <x-atoms.nav.logo href="/" />
    </div>
    <div class="bg-white px-6 py-3 flex imtes-center justify-between border-t border-slate-100">

                <x-atoms.nav.link href="{{ asset('servicios') }}" :active="request()->routeIs('servicios')">Servicios</x-atoms.nav.link>
                <x-atoms.nav.link href="{{ asset('productos') }}" :active="request()->routeIs('productos')">Productos</x-atoms.nav.link>
                <x-atoms.nav.link href="{{ asset('nosotros') }}" :active="request()->routeIs('nosotros')">Nosotros</x-atoms.nav.link>
                <x-atoms.nav.link href="{{ asset('contacto') }}" :active="request()->routeIs('contacto')">Contacto</x-atoms.nav.link>
                <x-atoms.nav.link href="{{ asset('faq') }}" :active="request()->routeIs('faq')">FAQ</x-atoms.nav.link>
                <x-atoms.nav.link href="{{ asset('cobertura') }}" :active="request()->routeIs('cobertura')">Cobertura</x-atoms.nav.link>
        </div>
    </div>
</nav>
 