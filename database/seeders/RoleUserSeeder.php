<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RoleUser;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        //Esta el factory en userSeeder
        //RoleUser::factory()->count(10)->create(['role_id' => "3"]); //Rol 3 alumno tienen que ser 1000
        //RoleUser::factory()->count(10)->create(['role_id' => "2"]); //Rol 2 profesor tienen que ser 80
    }
}
