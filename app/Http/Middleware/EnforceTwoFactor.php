<?php

// app/Http/Middleware/EnforceTwoFactor.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceTwoFactor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // 1. Liste des rôles à haut risque (Admins et Managers)
        $restrictedRoles = ['admin', 'manager'];

        // 2. Vérification des conditions :
        // - L'utilisateur appartient à un rôle restreint
        // - ET son 2FA n'est pas encore confirmé (colonne two_factor_confirmed_at)
        if ($user && in_array($user->role, $restrictedRoles) && ! $user->two_factor_confirmed_at) {

            // Redirection forcée vers le terminal de sécurité Ace Berg
            return redirect()->route('profile.security')
                ->with('warning', 'ACCÈS RESTREINT : En tant qu\'administrateur, le protocole 2FA est obligatoire pour votre terminal.');
        }

        return $next($request);
    }
}
