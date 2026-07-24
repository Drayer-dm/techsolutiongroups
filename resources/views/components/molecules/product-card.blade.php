@props(['producto'])

<div class="bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden flex flex-col">
    <img src="{{ asset('images/productos/' . $producto['imagen']) }}" alt="{{ $producto['nombre'] }}" class="w-full h-48 object-cover">

    <div class="p-4 flex flex-col flex-1">
        <h3 class="font-bold text-lg mb-1">{{ $producto['nombre'] }}</h3>
        <p class="text-slate-500 text-sm mb-3 flex-1">{{ $producto['descripcion'] }}</p>
        <p class="font-semibold text-slate-800 mb-3">${{ number_format($producto['precio'], 0, ',', '.') }}</p>

        <button class="bg-blue-950 text-white py-2 rounded-md hover:bg-blue-900 transition">
            Agregar al carrito
        </button>
    </div>
</div>