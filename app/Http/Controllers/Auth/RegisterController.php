<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View{
        return view('auth.register');
    }

    public function store (Request $request): RedirectResponse{
        $datos = $request->validate([
            'nombre' => ['required','string','max:70'],
            'correo' => ['required','string','email','max:120','unique:usuarios,correo'],
            'clave' => ['required','confirmed', Password::defaults()],
        ]);

        $usuario = Usuario::create($datos);

        Auth::login($usuario);

        return redirect()->route('servicios-proyectos.index')
        ->with('status', "Cuenta Creada. Bienvenido a Tech Solution Groups, {$usuario->nombre}!");
    }
}