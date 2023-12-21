<?php
namespace Database\Factories;

// RoleUserFactory.php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleUserFactory extends Factory
{
    protected $model = \App\Models\RoleUser::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()
        ];
    }
}
