<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modules')->insert([
            //SMR
            ['code' => 221, 'name' => 'Montaje y mantenimiento de equipos', 'hours' => 231, "created_at" => now(), "updated_at" => now()],
            ['code' => 222, 'name' => 'Sistemas operativos monopuesto', 'hours' => 165, "created_at" => now(), "updated_at" => now()],
            ['code' => 223, 'name' => 'Aplicaciones ofimáticas', 'hours' => 231, "created_at" => now(), "updated_at" => now()],
            ['code' => 224, 'name' => 'Sistemas operativos en red', 'hours' => 168, "created_at" => now(), "updated_at" => now()],
            ['code' => 225, 'name' => 'Redes locales', 'hours' => 231, "created_at" => now(), "updated_at" => now()],
            ['code' => 226, 'name' => 'Seguridad informática', 'hours' => 99, "created_at" => now(), "updated_at" => now()],
            ['code' => 227, 'name' => 'Servicios en red', 'hours' => 189, "created_at" => now(), "updated_at" => now()],
            ['code' => 228, 'name' => 'Aplicaciones web', 'hours' => 105, "created_at" => now(), "updated_at" => now()],
            ['code' => 200, 'name' => 'Inglés técnico', 'hours' => 33, "created_at" => now(), "updated_at" => now()],
            ['code' => 229, 'name' => 'Formación y orientación laboral', 'hours' => 105, "created_at" => now(), "updated_at" => now()],
            ['code' => 230, 'name' => 'Empresa e iniciativa empresarial', 'hours' => 63, "created_at" => now(), "updated_at" => now()],
            ['code' => 231, 'name' => 'Formación en centros de trabajo', 'hours' => 380, "created_at" => now(), "updated_at" => now()],
            //DAW
            ['code' => 483, 'name' => 'Sistemas informáticos', 'hours' => 165, "created_at" => now(), "updated_at" => now()],
            ['code' => 484, 'name' => 'Bases de datos', 'hours' => 198, "created_at" => now(), "updated_at" => now()],
            ['code' => 485, 'name' => 'Programación', 'hours' => 264, "created_at" => now(), "updated_at" => now()],
            ['code' => 373, 'name' => 'Lenguajes de marcas y sistemas de gestión de información', 'hours' => 132, "created_at" => now(), "updated_at" => now()],
            ['code' => 487, 'name' => 'Entornos de desarrollo', 'hours' => 99, "created_at" => now(), "updated_at" => now()],
            ['code' => 612, 'name' => 'Desarrollo web en entorno cliente', 'hours' => 140, "created_at" => now(), "updated_at" => now()],
            ['code' => 613, 'name' => 'Desarrollo web en entorno servidor', 'hours' => 180, "created_at" => now(), "updated_at" => now()],
            ['code' => 614, 'name' => 'Despliegue de aplicaciones web', 'hours' => 100, "created_at" => now(), "updated_at" => now()],
            ['code' => 615, 'name' => 'Diseño de interfaces web', 'hours' => 120, "created_at" => now(), "updated_at" => now()],
            ['code' => 616, 'name' => 'Proyecto de desarrollo de aplicaciones web', 'hours' => 50, "created_at" => now(), "updated_at" => now()],
            //DAM
            ['code' => 486, 'name' => 'Acceso a datos', 'hours' => 120, "created_at" => now(), "updated_at" => now()],
            ['code' => 488, 'name' => 'Desarrollo de interfaces', 'hours' => 140, "created_at" => now(), "updated_at" => now()],
            ['code' => 489, 'name' => 'Programación multimedia y dispositivos móviles', 'hours' => 100, "created_at" => now(), "updated_at" => now()],
            ['code' => 490, 'name' => 'Programación de servicios y procesos', 'hours' => 80, "created_at" => now(), "updated_at" => now()],
            ['code' => 492, 'name' => 'Proyecto de desarrollo de aplicaciones multiplataforma', 'hours' => 50, "created_at" => now(), "updated_at" => now()],

        ]);
        
    }

}
