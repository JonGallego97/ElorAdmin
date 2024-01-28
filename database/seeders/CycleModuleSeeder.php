<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CycleModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Modulos SMR
        DB::table('cycle_module')->insert([
            ['cycle_id' => 1, 'module_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 2,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 5,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 1, 'module_id' => 8, 'created_at' => now(), 'updated_at' => now()],
          

        
        ]);

        // Modulos DAW
        DB::table('cycle_module')->insert([
            ['cycle_id' => 3, 'module_id' => 13,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 24,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 25, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 19, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 20,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 21,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 22,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 23,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 3, 'module_id' => 26,'created_at' => now(), 'updated_at' => now()],
        ]);

        // Modulos DAM
        DB::table('cycle_module')->insert([
            ['cycle_id' => 2, 'module_id' => 13,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 32,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 33, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 35, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 27, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 28, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 29, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => 2, 'module_id' => 31, 'created_at' => now(), 'updated_at' => now()],
        
        ]);
        // TÉCNICO SUPERIOR EN DISEÑO EN FABRICACIÓN MECANICA
        $cycleId = 4;
        DB::table('cycle_module')->insert([
            ['cycle_id' => $cycleId, 'module_id' => 49,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 50,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 51, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 52, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 53, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 54, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 55, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 56, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 57, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 58, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 59, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // TÉCNICO SUPERIOR EN PROGRAMACIÓN DE LA PRODUCCIÓN DE LA FABRICACIÓN MECÁNICA
        $cycleId = 5;
        DB::table('cycle_module')->insert([
            ['cycle_id' => $cycleId, 'module_id' => 36,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 37,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 38, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 39, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 41, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 42, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 43, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 44, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 46, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 47, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 48, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // TÉCNICO SUPERIOR EN AGENCIAS DE VIAJE Y GESTIÓN DE EVENTOS
        $cycleId = 6;
        DB::table('cycle_module')->insert([
            ['cycle_id' => $cycleId, 'module_id' => 66,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 67,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 68, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 69, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 70, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 71, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 60, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 61, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 62, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 63, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 64, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 65, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // TÉCNICO SUPERIOR EN GUÍA, INFORMACIÓN Y ASISTENCIA TURÍSTICA
        $cycleId = 7;
        DB::table('cycle_module')->insert([
            ['cycle_id' => $cycleId, 'module_id' => 66,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 67,'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 68, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 69, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 70, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 71, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 72, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 73, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 74, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 75, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 76, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 77, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 78, 'created_at' => now(), 'updated_at' => now()],
            ['cycle_id' => $cycleId, 'module_id' => 79, 'created_at' => now(), 'updated_at' => now()],
        ]); 
        
        
        
    }
}
