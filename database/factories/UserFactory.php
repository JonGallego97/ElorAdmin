<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Database\Factories\RoleUser;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $fakerSpain =  \Faker\Factory::create('es_ES');

        $image = null;

        $year = $fakerSpain->randomElement([1, 2]);

        $name = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $fakerSpain->firstName);
        $surname1 = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $fakerSpain->lastName);
        $surname2 = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $fakerSpain->lastName);

        return [
            'password' => bcrypt('contraseña'), // Puedes utilizar un método más seguro para generar contraseñas
            'name' => $name,
            'surname1' => $surname1,
            'surname2' => $surname2,
            'email' => $name . "." . $surname1 . substr($surname2, 0, 2) . '@elorrieta-errekamari.com',
            'DNI' => $fakerSpain->unique()->randomNumber(8),
            'address' => $fakerSpain->address,
            'phoneNumber1' => $fakerSpain->numerify('#########'),
            'phoneNumber2' => $fakerSpain->numerify('#########'),
            'image' => "",
            'dual' => false,
            'firstLogin' => $fakerSpain->boolean,
            'year' => $year,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }


    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
       return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
