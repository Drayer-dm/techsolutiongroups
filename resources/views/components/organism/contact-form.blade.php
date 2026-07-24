<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="px-4 py-5 border-b border-slate-100 sm:px-6">
        <h2 class="text-lg font-semibold text-slate-900">Envianos un mensaje</h2>
        <p class="text-sm text-slate-600 mt-1">Completa el formulario y te responderemos a la brevedad.</p>
    </div>

    <form class="px-4 py-5 space-y-5 sm:px-6 sm:py-6">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-molecules.form.field
                id="nombre"
                name="nombre"
                label="Nombre Completo"
                placeholder="Juan Pérez"
                required
            />
            <x-molecules.form.field
                id="correo"
                name="email"
                label="Correo Electronico"
                type="email"
                placeholder="juan@empresa.com"
                required
            />
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-molecules.form.select-field
                name="asunto"
                id="asunto"
                label="Asunto"
                :options="[
                    'consultas' => 'Consultas',
                    'felicitaciones' => 'Felicitaciones',
                    'reclamos' => 'Reclamos',
                    'otro' => 'Otro',
                ]"
                placeholder="Seleccione Asunto"
                required
            />
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-molecules.form.field
                id="telefono"
                name="telefono"
                label="Teléfono"
                type="tel"
                placeholder="56 9 1234 5678"
            />
        </div>

        <div class="grid grid-cols-1 gap-5">
            <x-molecules.form.textarea-field
                id="mensaje"
                name="mensaje"
                label="Mensaje"
                placeholder="¿Tienes Algun Comentario?"
                required
            />
        </div>

        <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-end">
            <x-atoms.form.button>
                Enviar
            </x-atoms.form.button>

            <x-atoms.form.button type="reset" variant="secondary">
                Limpiar
            </x-atoms.form.button>
        </div>
    </form>
</div>