<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTauth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTauth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $usuario = JWTAuth::parseToken()->authenticate();

            if(!$usuario) {
                return response()->json(['error' => 'Usuario no Encontrado'], '401');
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token Expirado'], '401');
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token Invalido'], '401');
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token Ausente'], '401');
        }

        return $next($request);
    }
}
