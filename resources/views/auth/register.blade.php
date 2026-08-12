<x-layout>
    <x-slot:title>Registro - TechSolutions</x-slot:title>

    <section class="mx-auto w-full max-w-md px-4 sm:px-6">
        <div class="bg-white dark:bg-slate-900 rounded-lg shadow-sm overflow-hidden">
            <div class="px-4 py-5 border-b border-slate-100 dark:border-slate-700 sm:px-6">
                <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Crear cuenta</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Completa tus datos para registrarte.</p>
            </div>

            @if (session('status'))
                <p class="mx-4 mt-4 rounded-md bg-green-50 px-4 py-2 text-sm text-green-700 sm:mx-6">
                    {{ session('status') }}
                </p>
            @endif

            <form method="POST" action="{{ route('register') }}" class="px-4 py-5 space-y-5 sm:px-6 sm:py-6">

                @csrf

                <x-molecules.form.field
                    id="nombre"
                    name="nombre"
                    label="Nombre"
                    placeholder="Juan Perez"
                    required
                />

                <x-molecules.form.field
                    id="correo"
                    name="correo"
                    label="Correo"
                    type="email"
                    placeholder="tu@correo.cl"
                    required
                />

                <x-molecules.form.field
                    id="clave"
                    name="clave"
                    label="Clave"
                    type="password"
                    placeholder="xxxxxxxx"
                    required
                />

                {{-- Agregamos confirmacion de clave por buena practica (todo valido pa la nueva ley de proteccion de datos) --}}

                <x-molecules.form.field
                    id="clave_confirmation"
                    name="clave_confirmation"
                    label="Confirmar Clave"
                    type="password"
                    placeholder="xxxxxxxx"
                    required
                />

                <div class="flex flex-col gap-3 pt-2">
                    <x-atoms.form.button type="submit" class="w-full">
                        Registrarse
                    </x-atoms.form.button>
                </div>
            </form>

            <div class="px-4 pb-6 text-center text-sm text-slate-600 dark:text-slate-400 sm:px-6">
                Ya tienes cuenta?
                <a href="{{ route('login') }}" class="font-semibold text-[#10243e] hover:underline dark:text-slate-200">
                    Inicia sesion
                </a>
            </div>
        </div>
    </section>
</x-layout> 

