<?php

use Illuminate\Support\Facades\Route;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

Route::middleware('jwt.custom')->group(function () {
    Route::get('/me', function () {
        // Si el middleware dejó pasar, el token era válido y este user existe.
        return response()->json(JWTAuth::user());
    });
});

