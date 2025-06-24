<?php
namespace Database\Factories;

use App\Models\Deplacement;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeplacementFactory extends Factory
{
    protected $model = Deplacement::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 week');
        $endDate = (clone $startDate)->modify('+'.rand(1, 5).' days');

        return [
            'utilisateur_id' => Utilisateur::inRandomOrder()->first()?->id ?? Utilisateur::factory(),
            'objet' => $this->faker->sentence(4),
            'lieu' => $this->faker->city(),
            'date_depart' => $startDate->format('Y-m-d'),
            'date_retour' => $endDate->format('Y-m-d'),
            'moyen_transport' => $this->faker->randomElement(['voiture', 'train', 'avion', 'bus']),
            'cout_estime' => $this->faker->randomFloat(2, 50, 1000),
            'statut' => $this->faker->randomElement(['en_attente', 'accepté', 'refusé', 'réalisé']),
            'commentaire_validation' => $this->faker->optional()->sentence(),
            'date_validation' => $this->faker->optional()->dateTime(),
        ];
    }
}
