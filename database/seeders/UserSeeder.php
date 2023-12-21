<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleUser;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleUser::factory()->count(13)->create(['role_id' => "3"]); //Rol 3 alumno tienen que ser 1000
        RoleUser::factory()->count(4)->create(['role_id' => "2"]); //Rol 2 profesor tienen que ser 80

        DB::table('users')->insert([
            'id' => '0',
            'email' => 'admin@elorrieta-errekamari.com',
            'password' => Hash::make('Admin'),
            'name' => 'Admin',
            'surname1' => 'Admin',
            'surname2' => 'Admin',
            'DNI' => '12345678A',
            'address' => 'Dirección',
            'phoneNumber1' => 123456789,
            'phoneNumber2' => 987654321,
            'image' => '',
            'dual' => null,
            'firstLogin' => false,
            'year' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->where('email', 'admin@elorrieta-errekamari.com')->update(['id' => 0]);
        DB::table('role_users')->insert([
            'role_id' => 1,
            'user_id' => 0,
        ]);


    }
}
