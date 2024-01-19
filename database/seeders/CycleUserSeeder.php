<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cycle;

class CycleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtén algunos usuarios con el rol específico (id 2) y ciclos existentes
        $usersWithRoleTwo = User::whereHas('roles', function ($query) {
            $query->where('id', 2); // Asegúrate de que el id coincida con el rol que estás buscando
        })->get();

        $cycles = Cycle::all();

        //Obtiene el ultimo registrationNumber, en caso de dar error por que no encuentra, lo establece en 0.
        try {
            $lastRegistration = DB::table('cycle_users')->orderByDesc('cycle_registration_number')->first();
            $lastRegistrationNumber = $lastRegistration->cycle_registration_number;
        } catch (\Exception $e) {
            $lastRegistrationNumber = 0;
        }
        

        // Itera sobre los usuarios y asigna ciclos aleatorios a cada uno
        $usersWithRoleTwo->each(function ($user) use ($cycles,&$lastRegistrationNumber) {

            $registrationNumber = ++$lastRegistrationNumber;
            $registrationDate = rand(strtotime("01/01/1990"),strtotime(today()));
            $registrationDate = date('Y-m-d',$registrationDate);

            $user->cycles()->attach(
                $cycles->random(rand(1, $cycles->count()))->pluck('id')->toArray(),
                [
                    'cycle_registration_number' => $registrationNumber,
                    'registration_date' => $registrationDate
                ]
            );
        });
        // $usersWithRoleTwo->each(function ($user) use ($cycles) {

        //     $user->cycles()->attach(
        //         $cycles->random(rand(1, $cycles->count()))->pluck('id')->toArray(),
        //         ['cycle_registration_number' => rand(10000,10000000000000)]
        //     );
        // });


    }
}
