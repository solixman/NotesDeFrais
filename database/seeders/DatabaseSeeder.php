<?php

use Illuminate\Database\Seeder;
use App\Models\Utilisateur;
use App\Models\NoteDeFrais;
use App\Models\Deplacement;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 managers
        $managers = Utilisateur::factory()->count(5)->create([
            'role' => 'manager',
        ]);

        // Create 10 employees, assign to random managers
        $employees = Utilisateur::factory()->count(10)->create([
            'role' => 'employé',
        ])->each(function ($employee) use ($managers) {
            $employee->manager_id = $managers->random()->id;
            $employee->save();
        });

        // Create 3 accountants
        Utilisateur::factory()->count(3)->create(['role' => 'comptable']);

        // Create 2 admins
        Utilisateur::factory()->count(2)->create(['role' => 'admin']);

        // Create 30 expense notes for random users
        NoteDeFrais::factory()->count(30)->create();

        // Create 15 trips for random users
        Deplacement::factory()->count(15)->create();
    }
}
