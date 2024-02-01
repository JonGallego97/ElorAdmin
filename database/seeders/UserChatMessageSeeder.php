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

        DB::table('chats')->insert([
            'name' => 'Public',
            'is_Public' => '1',
            "created_at" => now(),
            "updated_at" => now(),
        
        ]);
        DB::table('chats')->insert([
            'name' => 'Admin',
            'is_Public' => '1',
            "created_at" => now(),
            "updated_at" => now(),
        
        ]);
        DB::table('user_chat')->insert([
            'user_id' => '0',
            'chat_id' => '1',
            'is_admin' => '1',
            "created_at" => now(),
            "updated_at" => now(),
        
        ]);

        DB::table('user_chat')->insert([
            'user_id' => '1',
            'chat_id' => '1',
            'is_admin' => '1',
            "created_at" => now(),
            "updated_at" => now(),
        
        ]);

        DB::table('user_chat')->insert([
            'user_id' => '1',
            'chat_id' => '2',
            'is_admin' => '1',
            "created_at" => now(),
            "updated_at" => now(),
        
        ]);

        DB::table('user_chat')->insert([
            'user_id' => '2',
            'chat_id' => '1',
            'is_admin' => '1',
            "created_at" => now(),
            "updated_at" => now(),
        
        ]);

    }
}
