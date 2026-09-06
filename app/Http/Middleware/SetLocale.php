<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Decide en qué idioma responde la aplicación, petición por petición.
 *
 * Los mensajes de validación viven en lang/es/ y lang/en/. Este middleware
 * solo elige cuál de los dos usa Laravel, llamando a App::setLocale().
 *
 * Orden de prioridad (gana el primero que dé un idioma soportado):
 *
 *   1. ?lang=es en la URL      → elección explícita del usuario, manda sobre todo
 *   2. session('locale')       → lo que el usuario eligió antes (solo rutas web)
 *   3. Accept-Language         → el idioma que el navegador declara
 *   4. config('app.locale')    → 'es', el valor de APP_LOCALE en el .env
 *
 * ── ¿Y por IP? ────────────────────────────────────────────────────────────
 * No se usa la IP a propósito. Accept-Language es lo que la persona configuró
 * en su navegador; la IP es dónde está parada la conexión. Son cosas distintas:
 * un chileno de viaje, una VPN o un hosting en otro país darían el idioma
 * equivocado. Además la IP sola no dice el país: hace falta una base de datos
 * de geolocalización (GeoIP) o un servicio externo, o sea una dependencia más,
 * latencia por petición y datos personales dando vueltas. Accept-Language es
 * gratis, viene en la misma petición y es más preciso.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $soportados = config('app.supported_locales', ['es']);

        $idioma = $this->desdeParametro($request, $soportados)
            ?? $this->desdeSesion($request, $soportados)
            ?? $this->desdeCabecera($request, $soportados)
            ?? config('app.locale', 'es');

        App::setLocale($idioma);

        // Se recuerda para las próximas peticiones. Las rutas de API no tienen
        // sesión (son stateless), por eso el hasSession(): sin esa guarda, un
        // request a /api/* reventaría acá.
        if ($request->hasSession()) {
            $request->session()->put('locale', $idioma);
        }

        return $next($request);
    }

    /**
     * ?lang=en en la URL. Sirve para probar los dos idiomas sin tocar el
     * navegador, y para un futuro selector de idioma en el menú.
     */
    private function desdeParametro(Request $request, array $soportados): ?string
    {
        $idioma = $request->query('lang');

        return is_string($idioma) && in_array($idioma, $soportados, true)
            ? $idioma
            : null;
    }

    /**
     * Lo que el usuario eligió en una petición anterior.
     */
    private function desdeSesion(Request $request, array $soportados): ?string
    {
        if (! $request->hasSession()) {
            return null;
        }

        $idioma = $request->session()->get('locale');

        return is_string($idioma) && in_array($idioma, $soportados, true)
            ? $idioma
            : null;
    }

    /**
     * La cabecera Accept-Language del navegador, por ejemplo:
     *
     *     Accept-Language: es-CL,es;q=0.9,en-US;q=0.8,en;q=0.7
     *
     * getPreferredLanguage() ya entiende los pesos q= y las variantes
     * regionales (es-CL cuenta como es), así que no hay que parsear a mano.
     */
    private function desdeCabecera(Request $request, array $soportados): ?string
    {
        if (! $request->hasHeader('Accept-Language')) {
            return null;
        }

        $idioma = $request->getPreferredLanguage($soportados);

        return in_array($idioma, $soportados, true) ? $idioma : null;
    }
}
