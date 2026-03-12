<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Fortify\RecoveryCode;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $name = fake()->name();
        // Génère un pseudo propre : jean.dupont.42
        $username = Str::slug($name, '.') . fake()->numberBetween(1, 99);

        return [
            // --- Identité de base ---
            'name' => $name,
            'username' => $username,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),

            // --- Système de Chat ASFM ---
            // Utilise UI-Avatars pour des photos de profil prêtes à l'emploi
            'avatar' => "https://ui-avatars.com" . urlencode($name) . "&color=7F9CF5&background=EBF4FF",
            'about' => fake()->randomElement([
                'Disponible pour discuter 💬',
                'Au travail 💻',
                'En réunion 📵',
                'Explorant Laravel 🚀',
                'Utilise ASFM Chat',
                null
            ]),
            'is_online' => fake()->boolean(25), // 25% de chances d'être en ligne
            'last_seen_at' => fake()->dateTimeBetween('-1 week', 'now'),

            // --- Colonnes Fortify 2FA (Par défaut null) ---
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ];
    }

    /**
     * État : Email non vérifié.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * État : Utilisateur avec 2FA déjà activé (Pratique pour tester le login 2FA).
     */
    public function withTwoFactor(): static
    {
        return $this->state(fn (array $attributes) => [
            'two_factor_secret' => encrypt('secret-key-test'),
            'two_factor_recovery_codes' => encrypt(json_encode([RecoveryCode::generate()])),
            'two_factor_confirmed_at' => now(),
        ]);
    }

    /**
     * État : Forcer l'utilisateur à être en ligne.
     */
    public function online(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_online' => true,
            'last_seen_at' => now(),
        ]);
    }
}
