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
        
    }
}
