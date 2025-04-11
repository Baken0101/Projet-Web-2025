<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cohort;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class StudentSeeder extends Seeder
{
    /**
     * Remplit la base de données avec 40 étudiants fictifs
     */
    public function run(): void
    {
        // Récupère la promotion avec l'ID 1, ou la crée si elle n'existe pas
        $cohort = Cohort::firstOrCreate(
            ['id' => 1],
            [
                'school_id'   => 1, // ID de l’école à laquelle la promotion est rattachée
                'name'        => 'Promo A',
                'description' => 'Formation test',
                'start_date'  => now()->subYear(),   // Commencée il y a un an
                'end_date'    => now()->addYear(),   // Finit dans un an
            ]
        );

        // Liste d'étudiants : chaque élément est un tableau [nom, prénom]
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

        // Boucle sur chaque étudiant pour les enregistrer en base
        foreach ($students as [$lastName, $firstName]) {
            // Génère une date de naissance aléatoire entre 18 et 25 ans
            $birthDate = Carbon::now()->subYears(rand(18, 25))->subDays(rand(0, 365));

            // Crée un utilisateur avec les données générées
            $user = User::create([
                'last_name'  => $lastName,
                'first_name' => $firstName,
                'email'      => strtolower($firstName . '.' . $lastName) . '@example.com',
                'birth_date' => $birthDate,
                'password'   => bcrypt($birthDate->format('d/m/Y')), // Mot de passe = date de naissance
            ]);

            // Attache l’utilisateur à l’école de la promo, avec le rôle "student"
            $user->schools()->attach($cohort->school_id, ['role' => 'student']);
        }
    }
}
