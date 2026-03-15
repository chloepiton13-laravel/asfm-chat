<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DocumentMilitaryFactory extends Factory
{
    public function definition(): array
    {
        $objet = $this->faker->sentence(4);

        return [
            'user_id' => User::factory(), // Crée un utilisateur s'il n'existe pas
            'reference_interne' => 'MIL-' . strtoupper($this->faker->bothify('??-####')),
            'slug' => Str::slug($objet) . '-' . Str::random(5),
            'objet' => $objet,
            'classification' => $this->faker->randomElement(['Diffusion Restreinte', 'Confidentiel', 'Secret', 'Très Secret']),
            'unite_emetteur' => $this->faker->randomElement(['1er RI', 'État-Major', 'BA 118', 'Marine Nationale']),
            'unite_destinataire' => $this->faker->randomElement(['COM-LOG', 'DRM', 'DGA', 'Hôpital Militaire']),
            'grade_signataire' => $this->faker->randomElement(['Colonel', 'Capitaine', 'Commandant', 'Lieutenant']),
            'nom_signataire' => $this->faker->lastName,
            'date_signature' => $this->faker->date(),
            'priorite_operationnelle' => $this->faker->randomElement(['Normal', 'Prioritaire', 'Immédiat', 'Flash']),
            'corps_message' => $this->faker->paragraphs(3, true),
            'statut' => $this->faker->randomElement(['Brouillon', 'Enregistré', 'Transmis', 'Archivé']),
            'fichier_joint' => null, // On laisse null par défaut pour les tests
        ];
    }
}
