<?php
namespace Database\Factories;

use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UtilisateurFactory extends Factory
{
    protected $model = Utilisateur::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'mot_de_passe' => Hash::make('password'), // or bcrypt('password')
            'role' => $this->faker->randomElement(['employé', 'manager', 'comptable', 'admin']),
            'manager_id' => null, // will be assigned manually in the seeder if needed
        ];
    }
}
