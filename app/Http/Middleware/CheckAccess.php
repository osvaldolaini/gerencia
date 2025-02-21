<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $checkAccess): Response
    {
        $user = $request->user();

        if (!in_array($checkAccess, $user->jsonAccesses) && !in_array('all', $user->jsonAccesses)) {

            $url = $request->fullUrl();
            $method = $request->getMethod();
            $user = Auth::user()->name;
            $log = "{$user} tentou acessar área que seu perfil não tem acesso {$method}@{$url}";
            Log::notice($log);
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
