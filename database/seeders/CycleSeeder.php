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
                'department_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'TÉCNICO SUPERIOR EN DESARROLLO DE APLICACIONES MULTIPLATAFORMA',
                'department_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'TÉCNICO SUPERIOR EN DESARROLLO DE APLICACIONES WEB',
                'department_id' => 1,

            ],
        ];

        foreach ($cycles as $cycle) {
            \App\Models\Cycle::create($cycle);
        }
    }
}
