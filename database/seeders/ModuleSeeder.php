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
            ['code' => 100, 'name' => 'Inglés técnico', 'hours' => 33, "created_at" => now(), "updated_at" => now()],
            ['code' => 229, 'name' => 'Formación y Orientación Laboral', 'hours' => 105, "created_at" => now(), "updated_at" => now()],
            ['code' => 230, 'name' => 'Empresa e Iniciativa Emprendedora', 'hours' => 63, "created_at" => now(), "updated_at" => now()],
            ['code' => 231, 'name' => 'Formación en Centros de Trabajo', 'hours' => 380, "created_at" => now(), "updated_at" => now()],
            //DAW
            ['code' => 200, 'name' => 'Inglés técnico', 'hours' => 33, "created_at" => now(), "updated_at" => now()],
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
            ['code' => 617, 'name' => 'Formación y Orientación Laboral', 'hours' => 99, "created_at" => now(), "updated_at" => now()],
            ['code' => 618, 'name' => 'Empresa e Iniciativa Emprendedora', 'hours' => 60, "created_at" => now(), "updated_at" => now()],
            ['code' => 619, 'name' => 'Formación en Centros de Trabajo', 'hours' => 360, "created_at" => now(), "updated_at" => now()],
            //DAM
            ['code' => 486, 'name' => 'Acceso a datos', 'hours' => 120, "created_at" => now(), "updated_at" => now()],
            ['code' => 488, 'name' => 'Desarrollo de interfaces', 'hours' => 140, "created_at" => now(), "updated_at" => now()],
            ['code' => 489, 'name' => 'Programación multimedia y dispositivos móviles', 'hours' => 100, "created_at" => now(), "updated_at" => now()],
            ['code' => 490, 'name' => 'Programación de servicios y procesos', 'hours' => 80, "created_at" => now(), "updated_at" => now()],
            ['code' => 491, 'name' => 'Sistemas de gestión empresarial', 'hours' => 100, "created_at" => now(), "updated_at" => now()],
            ['code' => 492, 'name' => 'Proyecto de desarrollo de aplicaciones multiplataforma', 'hours' => 50, "created_at" => now(), "updated_at" => now()],
            ['code' => 493, 'name' => 'Formación y Orientación Laboral', 'hours' => 99, "created_at" => now(), "updated_at" => now()],
            ['code' => 494, 'name' => 'Empresa e Iniciativa Emprendedora', 'hours' => 60, "created_at" => now(), "updated_at" => now()],
            ['code' => 495, 'name' => 'Formación en Centros de Trabajo', 'hours' => 360, "created_at" => now(), "updated_at" => now()],
            //Programación de la producción de fabricación mecánica
            ['code' => 007, 'name' => 'Interpretación gráfica', 'hours' => 132, "created_at" => now(), "updated_at" => now()],
            ['code' => 160, 'name' => 'Definición de procesos de mecanizado, conformado y montaje', 'hours' => 231, "created_at" => now(), "updated_at" => now()],
            ['code' => 164, 'name' => 'Ejecución de procesos de fabricación', 'hours' => 198, "created_at" => now(), "updated_at" => now()],
            ['code' => 165, 'name' => 'Gestión de la calidad, prevención de riesgos laborales y protección ambiental', 'hours' => 165, "created_at" => now(), "updated_at" => now()],
            ['code' => 166, 'name' => 'Verificación de productos', 'hours' => 165, "created_at" => now(), "updated_at" => now()],
            ['code' => 168, 'name' => 'Formación y Orientación Laboral', 'hours' => 99, "created_at" => now(), "updated_at" => now()],
            ['code' => 002, 'name' => 'Mecanizado por control numérico', 'hours' => 180, "created_at" => now(), "updated_at" => now()],
            ['code' => 161, 'name' => 'Fabricación asistida por ordenador', 'hours' => 160, "created_at" => now(), "updated_at" => now()],
            ['code' => 162, 'name' => 'Programación de sistemas automáticos de fabricación mecánica', 'hours' => 160, "created_at" => now(), "updated_at" => now()],
            ['code' => 163, 'name' => 'Programación de la produccción', 'hours' => 50, "created_at" => now(), "updated_at" => now()],
            ['code' => 167, 'name' => 'Proyecto de fabricación de productos mecánicos', 'hours' => 40, "created_at" => now(), "updated_at" => now()],
            ['code' => 169, 'name' => 'Empresa e Iniciativa Emprendedora', 'hours' => 60, "created_at" => now(), "updated_at" => now()],
            ['code' => 170, 'name' => 'Formación en Centros de Trabajo', 'hours' => 360, "created_at" => now(), "updated_at" => now()],
            //Diseño en fabricación mecánica
            ['code' => 245, 'name' => 'Representación gráfica en fabricación mecánica', 'hours' => 198, "created_at" => now(), "updated_at" => now()],
            ['code' => 247, 'name' => 'Diseño de productos mecánicos', 'hours' => 297, "created_at" => now(), "updated_at" => now()],
            ['code' => 431, 'name' => 'Automatización de la fabricación', 'hours' => 198, "created_at" => now(), "updated_at" => now()],
            ['code' => 432, 'name' => 'Técnicas de fabricación mecánica', 'hours' => 198, "created_at" => now(), "updated_at" => now()],
            ['code' => 434, 'name' => 'Formación y Orientación Laboral', 'hours' => 99, "created_at" => now(), "updated_at" => now()],
            ['code' => 428, 'name' => 'Diseño de útiles de procesado de chapa y estampación', 'hours' => 240, "created_at" => now(), "updated_at" => now()],
            ['code' => 429, 'name' => 'Diseño de moldes y modelos de fundición', 'hours' => 120, "created_at" => now(), "updated_at" => now()],
            ['code' => 430, 'name' => 'Diseño de moldes para productos poliméricos', 'hours' => 140, "created_at" => now(), "updated_at" => now()],
            ['code' => 433, 'name' => 'Proyecto de diseño de productos mecánicos', 'hours' => 50, "created_at" => now(), "updated_at" => now()],
            ['code' => 435, 'name' => 'Empresa e Iniciativa Emprendedora', 'hours' => 60, "created_at" => now(), "updated_at" => now()],
            ['code' => 436, 'name' => 'Formación en Centros de Trabajo', 'hours' => 360, "created_at" => now(), "updated_at" => now()],
            //Agencias de viaje y gestion de ventos
            ['code' => 397, 'name' => 'Gestión de productos turísticos', 'hours' => 140, "created_at" => now(), "updated_at" => now()],
            ['code' => 398, 'name' => 'Venta de servicios turísticos', 'hours' => 140, "created_at" => now(), "updated_at" => now()],
            ['code' => 399, 'name' => 'Dirección de entidades de intermediación turística', 'hours' => 140, "created_at" => now(), "updated_at" => now()],
            ['code' => 400, 'name' => 'Proyecto de agencias de viajes y gestión de eventos', 'hours' => 50, "created_at" => now(), "updated_at" => now()],
            ['code' => 402, 'name' => 'Empresa e Iniciativa Emprendedora', 'hours' => 60, "created_at" => now(), "updated_at" => now()],
            ['code' => 403, 'name' => 'Formación en Centros de Trabajo', 'hours' => 360, "created_at" => now(), "updated_at" => now()],
            //Guia Informacion y Asistencia Turistica
            ['code' => 171, 'name' => 'Estructura del mercado turístico ', 'hours' => 132, "created_at" => now(), "updated_at" => now()],
            ['code' => 172, 'name' => 'Protocolo y relaciones públicas', 'hours' => 132, "created_at" => now(), "updated_at" => now()],
            ['code' => 173, 'name' => 'Marketing turístico', 'hours' => 132, "created_at" => now(), "updated_at" => now()],
            ['code' => 383, 'name' => 'Destinos turísticos', 'hours' => 165, "created_at" => now(), "updated_at" => now()],
            ['code' => 384, 'name' => 'Recursos turísticos', 'hours' => 165, "created_at" => now(), "updated_at" => now()],
            ['code' => 179, 'name' => 'Inglés', 'hours' => 165, "created_at" => now(), "updated_at" => now()],
            ['code' => 389, 'name' => 'Formación y orientación laboral', 'hours' => 99, "created_at" => now(), "updated_at" => now()],
            ['code' => 385, 'name' => 'Servicios de información turística', 'hours' => 140, "created_at" => now(), "updated_at" => now()],
            ['code' => 386, 'name' => 'Procesos de guía y asistencia turística', 'hours' => 140, "created_at" => now(), "updated_at" => now()],
            ['code' => 387, 'name' => 'Diseño de productos turísticos', 'hours' => 140, "created_at" => now(), "updated_at" => now()],
            ['code' => 180, 'name' => 'Segunda lengua extranjera', 'hours' => 120, "created_at" => now(), "updated_at" => now()],
            ['code' => 388, 'name' => 'Proyecto de guía, información y asistencia turísticas', 'hours' => 50, "created_at" => now(), "updated_at" => now()],
            ['code' => 390, 'name' => 'Empresa e Iniciativa Emprendedora', 'hours' => 60, "created_at" => now(), "updated_at" => now()],
            ['code' => 391, 'name' => 'Formación en Centros de Trabajo', 'hours' => 360, "created_at" => now(), "updated_at" => now()],


        ]);
        
    }

}
