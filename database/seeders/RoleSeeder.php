<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert(
            ['name'=>'ADMINISTRADOR','created_at'=>now(),'updated_at'=>now()]
        );
        DB::table('roles')->insert(
            ['name'=>'PROFESOR','created_at'=>now(),'updated_at'=>now()]
        );
        DB::table('roles')->insert(
            ['name'=>'ALUMNO','created_at'=>now(),'updated_at'=>now()],
        );
        DB::table('roles')->insert(
            ['name'=>'JEFE DE ESTUDIOS','created_at'=>now(),'updated_at'=>now()]
        );
        DB::table('roles')->insert(
            ['name'=>'DIRECCIÓN','created_at'=>now(),'updated_at'=>now()]
        );
        DB::table('roles')->insert(
            ['name'=>'BEDEL','created_at'=>now(),'updated_at'=>now()]
        );
        DB::table('roles')->insert(
            ['name'=>'LIMPIEZA','created_at'=>now(),'updated_at'=>now()]
        );

    }
}
