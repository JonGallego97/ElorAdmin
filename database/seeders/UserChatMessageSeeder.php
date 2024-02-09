<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserChatMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chats')->insert([
            'name' => 'Bienvenida',
            'is_Public' => '1',
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
