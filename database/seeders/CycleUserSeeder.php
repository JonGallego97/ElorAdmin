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
            $cycleId = $cycles->random(1)->pluck('id')->toArray();
            $year = rand(1,2);
            if($year == 2) {
                $is_dual = rand(0,1);
            } else {
                $is_dual = null;
            }
            
            $random_date = date('Y-m-d', mt_rand(strtotime('1990-01-01'), time()));
            $user->cycles()->attach(
                $cycleId,
                [
                    'cycle_registration_number' => $registrationNumber,
                    'year' => $year,
                    'is_dual' => $is_dual,
                    'created_at' => $random_date,
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

            $languagesDeptId = Department::select('id')->where('name','Idiomas')->pluck('id')->first();
            $folDeptId = Department::select('id')->where('name','FOL')->pluck('id')->first();
            $eieDeptId = Department::select('id')->where('name','Empresa e Iniciativa Emprendedora')->pluck('id')->first();
            $specialModulesDeptIdArray = array($languagesDeptId,$folDeptId,$eieDeptId);


            $languageModules = ['Inglés técnico','Inglés', 'Segunda lengua extranjera'];
            $folModules = 'Formación y Orientación Laboral';
            $eieModules = 'Empresa e Iniciativa Emprendedora';


            $modulesInDepartment = Module::whereIn('id', function ($query) use ($user) {
                $query->select('module_id')
                      ->from('cycle_module')
                      ->whereIn('cycle_id', function ($subQuery) use ($user) {
                          $subQuery->select('id')
                                   ->from('cycles')
                                   ->where('department_id', $user->department_id);
                      });
            })->get();

            if($modulesInDepartment->isEmpty()) {
                $moduleNames = null;
                switch ($user->department_id) {
                    case $languagesDeptId:
                        $moduleNames = $languageModules;
                        break;
                    case $folDeptId:
                        $moduleNames = $folModules;
                        break;
                    case $eieDeptId:
                        $moduleNames = $eieModules;
                        break;
                }
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
            }

            if (!$modulesInDepartment->isEmpty()) {
                $maxModulesToAttach = 5;
                $randomModules = $modulesInDepartment->random(mt_rand(1, min($maxModulesToAttach, $modulesInDepartment->count())));
                foreach($randomModules as $module) {
                    $this->command->info("Prueba: " . in_array($user->department_id,$specialModulesDeptIdArray));
                    $isCorrect = false;
                    if (in_array($user->department_id,$specialModulesDeptIdArray)) {
                        $cycle_id = DB::table('cycle_module')
                            ->where('module_id', $module->id)
                            ->pluck('cycle_id')->toArray();
                            $isCorrect = true;
                    } else {
                        if(!in_array($module->name,$languageModules) && $module->name != $folModules && $module->name != $eieModules) {
                            $cycle_id = DB::table('cycle_module')
                            ->where('module_id', $module->id)
                            ->pluck('cycle_id')->toArray();          
                            $isCorrect = true;              
                        }
                    }
                    if ($isCorrect) {
                        $user->modules()->attach($module->id, ['cycle_id' => $cycle_id[0]]);
                        $isCorrect = false;
                    }           
                }
            }
        });

        

    }
}
