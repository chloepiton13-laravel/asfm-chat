<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Exécute le remplissage de la base de données.
     */
    public function run(): void
    {
        // 1. Créer VOTRE compte de test (Admin / Développeur)
        // Indispensable pour se connecter sans chercher un email aléatoire
        User::factory()->create([
            'name' => 'Admin ASFM',
            'username' => 'admin.asfm',
            'email' => 'admin@asfm.test',
            'password' => Hash::make('password'), // Mot de passe : password
            'is_online' => true,
            'about' => 'Développeur principal du projet ASFM 🚀',
            'email_verified_at' => now(),
        ]);

        // 2. Créer 149 utilisateurs aléatoires pour atteindre le total de 150
        // Ils utiliseront la logique de votre UserFactory (avatars, bios, pseudos)
        User::factory()->count(149)->create();

        // 3. (Optionnel) Créer quelques utilisateurs avec le 2FA déjà activé
        // Pour tester vos vues "Two-Factor Challenge" immédiatement
        User::factory()->count(5)->withTwoFactor()->create([
            'password' => Hash::make('password'),
        ]);
    }
}
