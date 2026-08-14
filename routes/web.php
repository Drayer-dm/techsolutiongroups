<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceProjectController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\ProyectoController;

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

Route::get('/servicios-proyectos', [ServiceProjectController::class, 'index'])->name('servicios-proyectos.index');

//Rutas de autenticacion: solo para visitantes sin sesion iniciada
Route::middleware('guest')->group(function () {

    Route::get('/registro', [RegisterController::class, 'create'])->name('register');
    Route::post('/registro', [RegisterController::class, 'store']);

    Route::get('/ingreso', [SessionController::class, 'create'])->name('login');
    Route::post('/ingreso', [SessionController::class, 'store'])->middleware('throttle:5,1');




    Route::get('/ingreso', function () {
        return view('auth.login');
    })->name('login');

});

//Rutas de cuenta: solo para usuarios con sesion iniciada
Route::middleware('auth')->group(function () {

    Route::get('/registro-proyecto', [ProyectoController::class, 'index'])->name('registro-proyecto.index');

    Route::post('/registro-proyecto', [ProyectoController::class, 'store'])->name('registro-proyecto.store');

    // {proyecto} activa el route model binding: Laravel busca el Proyecto por id solo
    Route::patch('/registro-proyecto/{proyecto}', [ProyectoController::class, 'update'])->name('registro-proyecto.update');

    Route::delete('/registro-proyecto/{proyecto}', [ProyectoController::class, 'destroy'])->name('registro-proyecto.destroy');

    Route::post('/salir', [SessionController::class, 'destroy'])->name('logout');
});
