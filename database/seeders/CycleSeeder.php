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
            ],
            [
                'id' => 2,
                'name' => 'TÉCNICO SUPERIOR EN DESARROLLO DE APLICACIONES MULTIPLATAFORMA',
            ],
            [
                'id' => 3,
                'name' => 'TÉCNICO SUPERIOR EN DESARROLLO DE APLICACIONES WEB',
            ],
        ];

        foreach ($cycles as $cycle) {
            \App\Models\Cycle::create($cycle);
        }
    }
}
