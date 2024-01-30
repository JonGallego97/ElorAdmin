<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cycle;
use App\Models\Department;
use App\Models\Module;
use App\Models\Role;

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
        

        // Itera sobre los usuarios y asigna un ciclo aleatorio a cada uno
        $userStudents->each(function ($user) use ($cycles,&$lastRegistrationNumber) {

            $registrationNumber = ++$lastRegistrationNumber;
            $registrationDate = rand(strtotime("01/01/1990"),strtotime(today()));
            $registrationDate = date('Y-m-d',$registrationDate);
            $cycleId = $cycles->random(1)->pluck('id')->toArray();
            $user->cycles()->attach(
                $cycleId,
                [
                    'cycle_registration_number' => $registrationNumber,
                    'registration_date' => $registrationDate
                ]
            );
            $cycles = Cycle::with('modules')->where('id',$cycleId[0])->get();
            foreach($cycles as $cycle) {
                    $modules = $cycle->modules;
                    foreach ($modules as $module) {
                        $user->modules()->attach($module,['cycle_id' => $cycleId[0]]);
                    }
            }
            
        });


        $userTeachers = User::whereHas('roles', function ($query) {
            $query->where('name', "PROFESOR"); // Asegúrate de que el id coincida con el rol que estás buscando
        })->get();

        $userTeachers->each(function ($user) {

            $isLanguagesDept = Department::select('id')->where('name','Idiomas')->pluck('id')->first();
            $isFolDept = Department::select('id')->where('name','FOL')->pluck('id')->first();
            $isEieDept = Department::select('id')->where('name','Empresa e Iniciativa Emprendedora')->pluck('id')->first();

            switch ($user->department_id) {
                case $isLanguagesDept:
                    $moduleNames = ['Inglés técnico','Inglés', 'Segunda lengua extranjera'];
                    break;
                case $isFolDept:
                    $moduleNames = 'Formación y Orientación Laboral';
                    break;
                case $isEieDept:
                    $moduleNames = 'Empresa e Iniciativa Emprendedora';
                    break;
            }

            
            if(isset($moduleNames)) {
                if(is_array($moduleNames)) {
                    $modulesInDepartment = Module::whereIn('id', function ($query) use ($moduleNames) {
                        $query->select('id')
                            ->from('modules')
                            ->whereIn('name', $moduleNames)
                            ->orWhere(function ($subQuery) use ($moduleNames) {
                                foreach ($moduleNames as $moduleName) {
                                    $subQuery->orWhere('name',$moduleName);
                                }
                            });
                    })->get();
                } else {
                    $modulesInDepartment = Module::whereIn('id', function ($query) use ($moduleNames) {
                        $query->select('id')
                            ->from('modules')
                            ->where('name', 'LIKE', '%' . $moduleNames . '%');
                    })->get();
                }
            } else {
                $modulesInDepartment = Module::whereIn('id', function ($query) use ($user) {
                    $query->select('module_id')
                          ->from('cycle_module')
                          ->whereIn('cycle_id', function ($subQuery) use ($user) {
                              $subQuery->select('id')
                                       ->from('cycles')
                                       ->where('department_id', $user->department_id);
                          });
                })->get();
            }


            if (!$modulesInDepartment->isEmpty()) {
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
