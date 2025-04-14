<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cohort;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class StudentSeeder extends Seeder
{
    /**
     * Remplit la base de données avec 40 étudiants fictifs
     */
    public function run(): void
    {
        // On récupère ou crée une promotion avec l'ID 1
        $cohort = Cohort::firstOrCreate(
            ['id' => 1],
            [
                'school_id'   => 1,
                'name'        => 'Promo A',
                'description' => 'Formation test',
                'start_date'  => now()->subYear(),
                'end_date'    => now()->addYear(),
            ]
        );

        $students = [
            ['Durand', 'Alice'], ['Martin', 'Paul'], ['Bernard', 'Claire'], ['Moreau', 'Lucas'],
            ['Robert', 'Sophie'], ['Petit', 'Julien'], ['Leroy', 'Emma'], ['Roux', 'Nathan'],
            ['Morel', 'Laura'], ['Fournier', 'Tom'], ['Benoit', 'Sarah'], ['Lopez', 'Ethan'],
            ['Meyer', 'Chloé'], ['Henry', 'Léo'], ['Adam', 'Lina'], ['Noël', 'Matthieu'],
            ['Lucas', 'Zoé'], ['Blanc', 'Maxime'], ['Garnier', 'Camille'], ['Rodriguez', 'Antoine'],
            ['Philippe', 'Julie'], ['Richard', 'Hugo'], ['Bourdon', 'Léa'], ['Garcia', 'Enzo'],
            ['Faure', 'Anna'], ['Martinez', 'Axel'], ['Pierre', 'Manon'], ['Joly', 'Noah'],
            ['Gomez', 'Inès'], ['Roy', 'Valentin'], ['Navarro', 'Maëlys'], ['Carpentier', 'Bastien'],
            ['Lemoine', 'Elsa'], ['Perrot', 'Théo'], ['Masson', 'Eva'], ['Muller', 'Yanis'],
            ['David', 'Lucie'], ['Robin', 'Clément'], ['Chevalier', 'Jade'], ['Guillet', 'Tom'],
        ];

        foreach ($students as [$lastName, $firstName]) {
            $birthDate = Carbon::now()->subYears(rand(18, 25))->subDays(rand(0, 365));

            $user = User::create([
                'last_name'  => $lastName,
                'first_name' => $firstName,
                'email'      => strtolower($firstName . '.' . $lastName) . '@example.com',
                'birth_date' => $birthDate,
                'password'   => bcrypt($birthDate->format('d/m/Y')),
            ]);

            $user->schools()->attach($cohort->school_id, [
                'role' => 'student',
                'cohort_id' => $cohort->id,
            ]);
        }
    }
}
