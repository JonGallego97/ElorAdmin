<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            'name' => 'Informatica',
            "created_at" => now(),
            "updated_at" => now(),
          
        ]);
        DB::table('departments')->insert([
            'name' => 'FOL',
            "created_at" => now(),
            "updated_at" => now(),
          
        ]);
        DB::table('departments')->insert([
            'name' => 'Ingles',
            "created_at" => now(),
            "updated_at" => now(),
          
        ]);
        DB::table('departments')->insert([
            'name' => 'Mantenimiento',
            "created_at" => now(),
            "updated_at" => now(),
          
        ]);
        DB::table('departments')->insert([
            'name' => 'Direccion',
            "created_at" => now(),
            "updated_at" => now(),
          
        ]);
        DB::table('departments')->insert([
            'name' => 'Secretaria',
            "created_at" => now(),
            "updated_at" => now(),
          
        ]);
    }
}
