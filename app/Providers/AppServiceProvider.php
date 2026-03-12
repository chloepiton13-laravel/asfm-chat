<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Player;
use App\Models\Game; // Utilisation de Game au lieu de Match
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
     // App/Providers/AppServiceProvider.php

     public function boot(): void
     {
         Gate::define('viewPulse', function ($user = null) {
             return true;
         });

         View::composer('layouts.sidebar', function ($view) {
             $view->with([
                 'sidebarCount' => [
                     'players' => Player::count(),
                     // On compte les matchs qui ne sont pas encore 'termine'
                     // OU ceux prévus après maintenant
                     'upcoming_games' => Game::where('statut', '!=', 'termine')
                                             ->where('joue_le', '>=', now())
                                             ->count(),
                 ]
             ]);
         });
     }
}
