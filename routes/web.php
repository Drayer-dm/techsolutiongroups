<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/productos', function () {
    $productos = [
        ['id' => 1, 'nombre' => 'Cámara de seguridad HD', 'precio' =>   45990, 'imagen' => 'camara.webp', 'descripcion' => 'Cámara IP full HD con visión nocturna.'],
        ['id' => 2, 'nombre' => 'Switch 8 puertos', 'precio' => 32990, 'imagen' => 'switch8.jpg', 'descripcion' => 'Switch gigabit para redes corporativas.'],
        ['id' => 3, 'nombre' => 'Router empresarial', 'precio' => 89990, 'imagen' => 'router.jpg', 'descripcion' => 'Router de alto rendimiento para oficinas.'],
        ['id' => 4, 'nombre' => 'Cable UTP Cat6 (100m)', 'precio' => 24990, 'imagen' => 'cat6.webp', 'descripcion' => 'Rollo de cable de red categoría 6.'],
    ];

    return view('productos', ['productos' => $productos]);
});

Route::get('/nosotros', function (){
    return view('nosotros');
});

Route::get('/contacto', function (){
    return view('contacto');
});

Route::get('/faq', function (){
    return view('faq');
});

Route::get('/cobertura', function (){
    return view('cobertura');
});

Route::get('/servicios-proyectos', function (){
    return view('servicios-proyectos');
})->name('servicios-proyectos.index');