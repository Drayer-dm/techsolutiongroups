<x-layout>
    <h1 class="text-3xl font-bold text-center mb-8 dark:text-white">Nuestros productos</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($productos as $producto)
            <x-molecules.product-card :producto="$producto" />
        @endforeach
    </div>
</x-layout>

{{-- Vista de productos pendiente de revisión visual, requisitos:
- Revisar grid responsivo (1/2/4 columnas) y espaciados entre cards
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}