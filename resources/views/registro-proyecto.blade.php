{{-- Aqui registramos los proyectos del usuario LOGEADO --}}

<x-layout>
    <x-slot:title>Mis Proyectos - TechSolutions</x-slot:title>

    <section class="mx-auto w-full max-w-4xl px-4 pt-24 pb-16 sm:px-6">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-[#113f59] dark:text-white">Mis Proyectos</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                Hola {{ auth()->user()->nombre }}, aqui registras y administras tus proyectos.
            </p>
        </div>

        @if (session('status'))
            <p class="mb-6 rounded-md bg-green-50 px-4 py-2 text-sm text-green-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('status') }}
            </p>
        @endif

        {{-- ARRIBA: formulario de registro --}}
        <div class="overflow-hidden rounded-2xl bg-white shadow-sm dark:bg-[#113f59]/20">

            <div class="border-b border-slate-100 px-4 py-5 dark:border-[#113f59] sm:px-6">
                <h2 class="text-lg font-semibold text-[#113f59] dark:text-white">Nuevo proyecto</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Queda asociado a tu cuenta automaticamente.
                </p>
            </div>

            <form method="POST" action="{{ route('registro-proyecto.store') }}" class="px-4 py-5 sm:px-6">

                @csrf

                {{-- No hay campo para created_by, ni visible ni oculto. Es a proposito:
                     lo pone el servidor desde la sesion. --}}

                <div class="grid gap-5 sm:grid-cols-2">

                    <x-molecules.form.field
                        id="nombre"
                        name="nombre"
                        label="Nombre del proyecto"
                        placeholder="Cableado oficina central"
                        required
                    />

                    {{-- El responsable no se escribe: lo pone el servidor con el nombre
                         de tu cuenta, igual que created_by. Esto es solo informativo. --}}
                    <x-molecules.form.readonly-field
                        label="Responsable"
                        :valor="auth()->user()->nombre"
                        ayuda="Se asigna solo con el nombre de tu cuenta."
                    />

                    <x-molecules.form.field
                        id="fecha_inicio"
                        name="fecha_inicio"
                        label="Fecha de inicio"
                        type="date"
                        required
                    />

                    <x-molecules.form.field
                        id="monto"
                        name="monto"
                        label="Monto (CLP)"
                        type="number"
                        placeholder="450000"
                        required
                    />

                    <x-molecules.form.select-field
                        name="estado"
                        label="Estado"
                        :options="$estados"
                        placeholder="Seleccione un estado"
                        required
                        class="sm:col-span-2"
                    />

                </div>

                <div class="mt-6">
                    <x-atoms.form.button type="submit" class="w-full sm:w-auto">
                        Registrar proyecto
                    </x-atoms.form.button>
                </div>
            </form>
        </div>

        {{-- ABAJO: listado de los proyectos del usuario --}}
        <div class="mt-10">
            <h2 class="mb-4 text-lg font-semibold text-[#113f59] dark:text-white">
                Proyectos registrados
                <span class="ml-1 text-sm font-normal text-slate-500">({{ $proyectos->count() }})</span>
            </h2>

            <x-organism.proyecto.lista :proyectos="$proyectos" :estados="$estados" />
        </div>

    </section>
</x-layout>
