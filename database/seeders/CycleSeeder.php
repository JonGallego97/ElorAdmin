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
                'department_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'TÉCNICO SUPERIOR EN DESARROLLO DE APLICACIONES MULTIPLATAFORMA',
                'created_at' => now(),
                'updated_at' => now(),
                'department_id' => 1,

            ],
            [
                'id' => 3,
                'name' => 'TÉCNICO SUPERIOR EN DESARROLLO DE APLICACIONES WEB',
                'created_at' => now(),
                'updated_at' => now(),
                'department_id' => 1,

            ],
        ];

        foreach ($cycles as $cycle) {
            \App\Models\Cycle::create($cycle);
        }
    }
}
