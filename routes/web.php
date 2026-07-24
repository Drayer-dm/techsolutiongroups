<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/productos',function () {
    return view('productos');
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

Route::get('/servicios', function (){
    return view('servicios');
});

Route::get('/', function (){
    return view('inicio');
});

Route::get('/nosotros', function (){
    return view('nosotros');
});