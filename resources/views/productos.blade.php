<x-layout>
    <x-slot:title>Productos - Techsolutions</x-slot:title>

    <main class="w-full bg-slate-50 dark:bg-[#0d1b2a] pt-32 pb-24 transition-colors duration-300">
        <section class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <!-- Encabezado de la Sección -->
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl font-bold text-[#113f59] dark:text-white tracking-tight">Nuestros Productos</h1>
                <div class="h-1 w-70 bg-orange-500 mt-3 mx-auto rounded-full"></div>
                <p class="mt-4 text-slate-600 dark:text-slate-300 max-w-2xl mx-auto text-sm sm:text-base">
                    Explora nuestra selección de productos tecnológicos diseñados para optimizar el rendimiento de tu infraestructura.
                </p>
            </div>

            <!-- Grid de Productos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($productos as $producto)
                    <x-molecules.product-card :producto="$producto" />
                @endforeach
            </div>

        </section>
    </main>
</x-layout>
{{-- Vista de productos pendiente de revisión visual, requisitos:
- Revisar grid responsivo (1/2/4 columnas) y espaciados entre cards
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}