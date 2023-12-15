<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert(
            ['name'=>'ADMINISTRADOR','created_at'=>now()]
        );
        DB::table('roles')->insert(
            ['name'=>'JEFE DE ESTUDIOS','created_at'=>now()]
        );
        DB::table('roles')->insert(
            ['name'=>'PROFESOR','created_at'=>now()]
        );
        DB::table('roles')->insert(
            ['name'=>'ALUMNO','created_at'=>now()],
        );
    }
}
