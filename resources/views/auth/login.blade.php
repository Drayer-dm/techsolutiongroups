<x-layout>
    <x-slot:title>Iniciar Sesion - TechSolutions</x-slot:title>

    <section class="mx-auto w-full max-w-d px-4 sm:px-6">

        <div class="bg-white dark:bg-slate-900 rounded-lg shadow-sm overflow-hidden">
                <div class="px-4 py-5 border-b border-slate-100 dark:border-slate-700" sm:px-6>
                    <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Inicia tu sesion</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Por favor, ingresa tus credenciales para continuar</p>
                </div>
            {{-- mensajes del controlador :D  // falta de datos en formulario, datos incompletos etc --}}

            @if (session('status'))
                <p class="mx-4 mt-4 rounded-md bg-green-50 px-4 pt-2 text-sm text-green-700 smmx-6">
                    {{ session('status') }}
                </p>
            @endif

            @if (session('error'))
                <p class="mx-4 mt-4 rounded-md bg-red-50 px-4 pt-2 text-sm text-red-700 smmx-6">
                    {{ session('error') }}
                </p>
            @endif

            {{-- action que apunta al route de login (Drayer uvu --)}}

            <form method="POST" action="{{ route('login') }}" class="px-4 py-5 space-y-5 sm:px-6 sm:py-6">
                
                @csrf

                <x-molecules.form.field
                    id="email"
                    name="email"
                    label="correo"
                    type="email"
                    placeholder="tu@correo.cl"
                    required
                />

                <x-molecules.form.field
                    id="password"
                    name="password"
                    label="Clave"
                    type="password"
                    type="password"
                    placeholder="xxxxxxxx"
                    required
                />

                <div class="flex flex-col gap-3 pt-2">
                    <x-atoms.form.button type="submit" class="w-full">
                        Iniciar Sesion
                    </x-atoms.form.button>
                </div>
            </form>

            <div class="px-4 pb-6 text-center text-sm text-slate-600 dark:text-slate-400 sm:px-6">
                No tienes cuenta?
                <a href="{{ route('register) }}" class="font-semibold text--[#10243e] hover:underline dark-text-slate-200">
                    Registrate aqui
                </a>
            </div>
        </div>
    </section>
</x-layout>

{{-- Cambios de estilo a orden de la directora encargada lu uvu --}}