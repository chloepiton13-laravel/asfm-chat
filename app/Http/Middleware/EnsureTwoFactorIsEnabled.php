<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorIsEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // 1. On vérifie si l'utilisateur est connecté
        // 2. On vérifie si son rôle est 'admin' (ou un autre rôle sensible)
        // 3. On vérifie si la colonne 'two_factor_secret' est vide dans la DB
        if ($user && ($user->role === 'admin' || $user->role === 'manager') && ! $user->two_factor_secret) {

            // On évite la boucle de redirection infinie si l'utilisateur est déjà sur la page de profil
            if (! $request->routeIs('profile.show')) {
                return redirect()->route('profile.show')
                    ->with('warning', 'SÉCURITÉ : Vous devez activer l\'authentification 2FA pour accéder au Dashboard.');
            }
        }

        return $next($request);
    }
}
