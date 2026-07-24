<x-layout>
    <h1 class="text-3xl font-bold text-center mb-8">Nuestros productos</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($productos as $producto)
            <x-molecules.product-card :producto="$producto" />
        @endforeach
    </div>
</x-layout>