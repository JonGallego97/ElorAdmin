<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call([
            DepartmentSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            RoleUserSeeder::class,
            CycleSeeder::class,
            ModuleSeeder::class,
            CycleModuleSeeder::class,
            CycleUserSeeder::class,
            ModuleUserSeeder::class,
            UserChatMessageSeeder::class,
        ]);
    }
}
