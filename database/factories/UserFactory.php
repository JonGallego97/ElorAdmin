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


        $name = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $fakerSpain->firstName);
        $surname1 = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $fakerSpain->lastName);
        $surname2 = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $fakerSpain->lastName);

        //Randomiza un numero de 8 digitos, luego divide entre 23 y saca el resto de la division. Luego dependiendo del numero del resto, adjunta la letra
        //Array del orden de las letras
        $DNILetterArray = array('T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E');

        $userID = $fakerSpain->unique()->randomNumber(8);
        $letter = round((float)$userID /23,2);
        $letter = round(($letter - (int)$letter)*23,0);
        $userID = $userID . $DNILetterArray[$letter];
        $tilesList = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ñ' => 'n',
            'Á' => 'A',
            'É' => 'E',
            'Í' => 'I',
            'Ó' => 'O',
            'Ú' => 'U',
            'Ñ' => 'N'
        );
     
    
        $userName = $name . "." . $surname1 . substr($surname2, 0, 2);
        $userName = str_replace(" ","",$userName);
        $userName = strtolower(strtr($userName, $tilesList));

        return [
            'password' => bcrypt(str_replace(".","",$userName) . date("Y")), // Puedes utilizar un método más seguro para generar contraseñas
            'name' => $name,
            'surname1' => $surname1,
            'surname2' => $surname2,
            'email' =>  $userName. '@elorrieta-errekamari.com',
            'DNI' => $userID,
            'address' => $fakerSpain->address,
            'phone_number1' => $fakerSpain->numerify('#########'),
            'phone_number2' => $fakerSpain->numerify('#########'),
            'image' => null,
            'is_dual' => false,
            'first_login' => $fakerSpain->boolean,
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
