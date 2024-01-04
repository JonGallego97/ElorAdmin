<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // Itera sobre los usuarios y asigna ciclos aleatorios a cada uno
        $usersWithRoleTwo->each(function ($user) use ($cycles) {
            $user->cycles()->attach(
                $cycles->random(rand(1, $cycles->count()))->pluck('id')->toArray()
            );
        });


    }
}
