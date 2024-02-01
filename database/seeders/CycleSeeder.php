<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cycles = [
            [
                'id' => 1,
                'name' => 'TÉCNICO EN SISTEMAS MICROINFORMÁTICOS Y REDES',
                'created_at' => now(),
                'updated_at' => now(),
                'department_id' => 5,
            ],
            [
                'id' => 2,
                'name' => 'TÉCNICO SUPERIOR EN DESARROLLO DE APLICACIONES MULTIPLATAFORMA',
                'created_at' => now(),
                'updated_at' => now(),
                'department_id' => 5,

            ],
            [
                'id' => 3,
                'name' => 'TÉCNICO SUPERIOR EN DESARROLLO DE APLICACIONES WEB',
                'created_at' => now(),
                'updated_at' => now(),
                'department_id' => 5,

            ],
            [
                'id' => 4,
                'name' => 'TÉCNICO SUPERIOR EN DISEÑO EN FABRICACIÓN MECANICA',
                'created_at' => now(),
                'updated_at' => now(),
                'department_id' => 9,

            ],
            [
                'id' => 5,
                'name' => 'TÉCNICO SUPERIOR EN PROGRAMACIÓN DE LA PRODUCCIÓN DE LA FABRICACIÓN MECÁNICA',
                'created_at' => now(),
                'updated_at' => now(),
                'department_id' => 9,

            ],  
            [
                'id' => 6,
                'name' => 'TÉCNICO SUPERIOR EN AGENCIAS DE VIAJE Y GESTIÓN DE EVENTOS',
                'created_at' => now(),
                'updated_at' => now(),
                'department_id' => 10,

            ],
            [
                'id' => 7,
                'name' => 'TÉCNICO SUPERIOR EN GUÍA, INFORMACIÓN Y ASISTENCIA TURÍSTICA',
                'created_at' => now(),
                'updated_at' => now(),
                'department_id' => 10,

            ],
        ];

        foreach ($cycles as $cycle) {
            \App\Models\Cycle::create($cycle);
        }
    }
}
