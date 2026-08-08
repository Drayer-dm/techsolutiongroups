<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class SessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse{
        //FUNCION LA CUAL SE BASA EN CREAR LA SESSION, SEGUN LEO DECIRLE LOOGIN ESTA MAL XDDDD
        $datos = $request->validate([
            'correo' => ['required', 'string', 'email'],
            'clave' => ['required', 'string'],
        ]);

        $credenciales = [
            'correo' => $datos['correo'],
            'password' => $datos['clave'],
        ];//VALIDAMOS LAS CREDENCIALES DEL USUARIO, SI SON CORRECTAS O NO, SI SON INCORRECTAS LANZAMOS UN ERROR DE VALIDACION

        if(!Auth::attempt($credenciales)) {
            throw ValidationException::withMessages([
                'correo' => 'Las credenciales son Incorrectas.',
            ]);//SI SON INCORRECTAS LANZAMOS UN ERROR DE VALIDACION (obviamente decimos q es el correo no le vamos a poner q otro usuario esta usando esa contrasena)XD
        }

        return redirect()->intended(route('servicios-proyectos.index'));
    }


    public function destroy(Request $request): RedirectResponse{
        Auth::logout();

        $request-> session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
//ESTA FUNCION TE CIERRA LA SESION 
    }
}
