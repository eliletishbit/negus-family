<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        
        // 1. On récupère l'utilisateur connecté via la requête
        $user = $request->user();
        //on test s' il n'es pta authentifié ou si son role n'est pas dans le tableau des roles
        if(!$user || !in_array($user->role, $roles)){
            //si l'une des regles est vraie on blouque l'acces
            abort(403, "accès refusé");
        }

        //si tout est bon on continue on redirige vers la route demandée
        return $next($request);

    }
}
