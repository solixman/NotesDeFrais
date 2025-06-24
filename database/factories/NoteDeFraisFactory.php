<?php


namespace Database\Factories;

use App\Models\NoteDeFrais;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteDeFraisFactory extends Factory
{
    protected $model = NoteDeFrais::class;

    public function definition(): array
    {
        return [
            'utilisateur_id' => Utilisateur::inRandomOrder()->first()?->id ?? Utilisateur::factory(),
            'date_depense' => $this->faker->date(),
            'categorie' => $this->faker->randomElement(['repas', 'hôtel', 'transport']),
            'montant' => $this->faker->randomFloat(2, 10, 500),
            'devise' => $this->faker->randomElement(['USD', 'EUR', 'MAD']),
            'description' => $this->faker->sentence(),
            'fichier_justificatif' => $this->faker->optional()->imageUrl(),
            'statut' => $this->faker->randomElement(['brouillon', 'soumise', 'validée', 'rejetée', 'remboursée']),
            'commentaire_validation' => $this->faker->optional()->paragraph(),
            'date_validation' => $this->faker->optional()->dateTime(),
        ];
    }
}
