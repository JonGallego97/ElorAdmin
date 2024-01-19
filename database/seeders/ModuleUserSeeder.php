<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Module;

class ModuleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $usersWithRoleTwo = User::whereHas('roles', function ($query) {
            $query->where('id', 2); // Reemplaza 2 con el ID del rol deseado
        })->get();

        foreach ($usersWithRoleTwo as $user) {
            // Obtén un usuario con el rol 2
            // Obtén los módulos que se pueden asignar a usuarios basados en la relación con ciclos
            $modulesForUsers = DB::table('cycle_module')
                ->whereIn('cycle_id', function ($query) use ($user) {
                    $query->select('cycle_id')
                        ->from('cycle_users')
                        ->where('user_id', $user->id);
                })->pluck('cycle_id','module_id')->toArray();
                
            // Obtén los IDs de los usuarios a los que se les asignarán los módulos
            $userIds = DB::table('cycle_users')
                ->where('user_id', $user->id)
                ->pluck('user_id')
                ->toArray();

            // Asigna módulos a usuarios
            foreach ($modulesForUsers as $module => $cycle) {
                //Pluck devuelve como valor de posicion de array el modulo y como valor el ciclo, por eso le damos la vuelta en el foreach
                $this->command->info('Cycle: '.$cycle.' - Module: '.$module.' ');
                    DB::table('module_user_cycle')->insert([
                        'user_id' => $user->id,
                        'module_id' => $module,
                        'cycle_id' => $cycle
                        // Agrega más columnas si es necesario y ajusta la lógica según tus necesidades
                    ]);
            }
        }

    }
}
