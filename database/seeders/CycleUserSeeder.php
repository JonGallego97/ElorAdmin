<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cycle;
use App\Models\Module;

class CycleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtén algunos usuarios con el rol específico (id 3) y ciclos existentes
        $userStudents = User::whereHas('roles', function ($query) {
            $query->where('name', "ALUMNO"); // Asegúrate de que el id coincida con el rol que estás buscando
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
        $userStudents->each(function ($user) use ($cycles,&$lastRegistrationNumber) {

            $registrationNumber = ++$lastRegistrationNumber;
            $registrationDate = rand(strtotime("01/01/1990"),strtotime(today()));
            $registrationDate = date('Y-m-d',$registrationDate);

            $user->cycles()->attach(
                $cycles->random(1)->pluck('id')->toArray(),
                [
                    'cycle_registration_number' => $registrationNumber,
                    'registration_date' => $registrationDate
                ]
            );
        });

        $userTeachers = User::whereHas('roles', function ($query) {
            $query->where('name', "PROFESOR"); // Asegúrate de que el id coincida con el rol que estás buscando
        })->get();

        $userTeachers->each(function ($user) {
            $modulesInDepartment = Module::whereIn('id', function ($query) use ($user) {
                $query->select('module_id')
                      ->from('cycle_module')
                      ->whereIn('cycle_id', function ($subQuery) use ($user) {
                          $subQuery->select('id')
                                   ->from('cycles')
                                   ->where('department_id', $user->department_id);
                      });
            })->get();
            if ($modulesInDepartment->count() > 0) {
                $maxModulesToAttach = 5;
                $randomModules = $modulesInDepartment->random(mt_rand(1, min($maxModulesToAttach, $modulesInDepartment->count())));
                foreach($randomModules as $module) {
                    $cycle_id = DB::table('cycle_module')
                        ->where('module_id', $module->id)
                        ->pluck('cycle_id')->toArray();

                    // Verificar que se obtuvieron ciclos
                    if (!empty($cycle_id)) {
                        // Adjuntar el módulo al usuario con los ciclos correspondientes
                        $user->modules()->attach($module->id, ['cycle_id' => $cycle_id[0]]);
                    }
                }           
            }
            
        });



    }
}
