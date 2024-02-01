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

        //Randomiza un numero de 8 digitos, luego divide entre 23 y saca el resto de la division. Luego dependiendo del numero del resto, adjunta la letra
        //Array del orden de las letras
        $DNILetterArray = array('T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E');

        $userID = $fakerSpain->unique()->randomNumber(8);
        $letter = round((float)$userID /23,2);
        $letter = round(($letter - (int)$letter)*23,0);
        $userID = $userID . $DNILetterArray[$letter];
        $userName = trim(strtolower($name . "." . $surname1 . substr($surname2, 0, 2)));

        return [
            'password' => bcrypt('contraseña'), // Puedes utilizar un método más seguro para generar contraseñas
            'name' => $name,
            'surname1' => $surname1,
            'surname2' => $surname2,
            'email' =>  $userName. '@elorrieta-errekamari.com',
            'DNI' => $userID,
            'address' => $fakerSpain->address,
            'phone_number1' => $fakerSpain->numerify('#########'),
            'phone_number2' => $fakerSpain->numerify('#########'),
            'image' => "iVBORw0KGgoAAAANSUhEUgAAAMAAAADACAYAAAEl21yRAAANlUlEQVR4nOxdLZRlxRFuopIoQCVRgAJUEgVRgAouONaBC451rAoOHDhwxC2OOOKIG7ly5MqVK1cufJNzhzfvvXtfd9+u/qq6vzqnzp7dnbnd1VVf/1RXVafnxpRyf/Crr75+/kL6zS1/8cWXbRrAhw4/fMyf/POT+ga2PnzM/hoo+fhWI2pg5iF6+vRp0ccfPXpU1kCpFNVTxZ6Przbw5MmTk1/e+vDWMJ00UNLLnJ9Ney3nUiNmDcAK7zTQ8uOHUtw08ME/PjBp4C9//uv/G7D4+MJqIG+ILCm7gRxkVzWQi9iqBkqnhaIGauceHw3smXvUQJshqtHDs2fPbBvwB7TcRi7RJg6Wcb26ujr58I8//vfk57MaKOllzs+abFvONtDq48eN3DTw/t/fb97Aq6+89msDrT9+KIVpA7DCZPXxhQdoYBVFQaiZALVWTBWgNSS7CfDxRx+b2PO777xnL4A1KEu1USTA22/9rYsAL734so0APTpfqgUJIA30NKFeODBfB7x0vloAC0FqqViA3/329ycNnju25fAPP/zn7IA0F+CN1980GT3Q3gWt2ZXH2t7m8399fvOnlYmdFcDKOb6XYQkXBWB3slQbZhcqvYQwvbDpIYT5dYo1xxfgp5/+R+/Ebg1EJgnApuYaWDZ7a9yamgiAXWUp+L777t8tmt4vwN5ZhCpAq6mQIkDr+byrAFaLUhcBrFdWCcAc/RotuPSNhhdgCY9rKoDVrcxaZFxzAXp1vtSMJEAYDVxyL7oX4PHjx906f+z0bSIAyNvozycAAmisO49QejMBQJ5Gv0oASyFqqEoAHMhbd/7BZw/6CQC6/+n9Zp1H2B7lUN8C1KWg3SXA0mHsTA+phc3jLs10FsoB3R//8KeLnT5387gH0FkCbHXo+vo6u7FjOkyfqhUitbLxS7mi58ylxeksWQF0uSNucU+MjWSxAHtnl9ZcJAC7syVChLvo3hQgwoUfMtpXBWB3rkYLtwLAF8PuWC5jwTwRgN2pWi2k0oXFC9/78N6vArA7s0cL8QWIMHVuTanmOS7WLAHoGrDIg+vFcDgr3Ea0j8JZEJat5ZR6zPh3/H8kcqkAq71Byb3PVAqA/+ZSoB07HGBIBeT4Ub2lPQ6hAPaAb/HQCmBMM94V0UUBl24wvPJanb5QCsC9L3sg9zBy6cIq4Lima1S2VIKZAqJOO2tsdcAzUwB7wCw4jAJqEoEicG0cU3cF4GDDHqwoKDBRAHuQpAAHAyUEOBisaacghMuxB8qCUROtNWkbSrR+UwVEjNdhnIZNXRGRQta2GF7csM64SC7oNQ7vju6ZtOt90aVdyPTIlmvJW7H9oa8kvW9R96R+hbqUt0j628PYtTGoiwLgHd0SkLVbOgzWP6aHD7/PfhTQpQLWgk7PlaXseYt2aVDX+m21IDdVQOngIW03h3A5XlrnFEkQuZfql16t3JOZaK6AlrubHlEIIOxwWp1P9kbXJe/bSlhybVIvBrrXGaRWEWn0/bz380ORAka+amzNTRWA57nYAkXknG1sihLBHJmrFcDu+EhcrAB2h0fkc0VtQtW8GIGPnxgNV7NjBF5VALtjM/GJAr755lt6p2bipYBa2JIpI/CtAuBvYXdmRsY9SOiKLyNwgguY3YmZOcm7SVbA4WOLo0SyeWdcy8LBuXoSFvUjKYBMUoAUMDeFQwACps5VzMK/Idru2NvonVwrABfce949RpDVnjLp0yrAwjXSO+g2pAJ6nENefeU1tpj+FMDIJ2sZXhhaAexTKXvRpikArg/24HsoZ0lRgLfkjOETNKLkDx+/szScAiLUEeqNhG4KwIGIPbi53LP+dDcFsAe1lIdSQNRs+SEUEGHez314KqQC2IPoHQWmCmj5eCmLQ1fOZQ9eBBQky4sT9sB5rhdqroCoO5/eKFDNOLLXVKWLyS4KEwXg1ok9ZUSZhlS6WArgW7YQ4GBwa9NM3U1BiOVhD1Skq8vmCoj8RPElRiKjewV4vO/1vBVtroCRXBAhFaApiKwALcJkBYDYU0Ukf5AUUKAAC5ICRlTAnqQKr2wV1m6igBEX4iWvtzXpQoY4/ZgqAIlzbKvtUWV9LykqguQF7aKAEWqOWr6gZK6AESqxWFd0Nw9NjIwCa+vvFh3NHsha7kFdFBDRQ9rj/ZiuCRqRQlV6TD2UHDH2wHqaemhZkuzB9Za4TckTZg+yl8GnZsp7i56eslaEh1dW4bNiUhcFbDmzmPnDW/nAlg64bgpAZknuHIunAr1crvQsX9D9QmarhBgUZHlegFVvPbiG/1v7XVR3CaGAHEvOsaqW7w7ntJdTRMTiWrKpAkoHJvf5PyRMlzwiB0svSbIu3ZG13K42UcCehZRZTG/PLqxVQY/kJRnbOiHaYnpr0eddClh7/HgPY/qwuATBxsBigUelR4oCLAb/mDHv74nJR6h8Dy/sHiUkr4O/pZTDcsVg9Ad/Z7q8a3dIKdLge+caJaRRCu554dKFOY1Y8y1SGGO2AthCRePcw1qWAtjCROUmChgpxrM357i0NxWAmEi2ENH5khdVT5p3UEKVAhCYxLaeGbamelOevCs6qwA9adgv2u6sAtiQnQkFaYYMR8/b0hMFsDs5Om8qYIRSw975+O7gjgLYnZuFzypgxORqr4yaSicK6BmZNjvjVu9EAexOzcZ3FCCnW38FLHFFNwrQPS/vTHCjADYcZ2UpwIMCRignEPmyJiGKmN2RWRkxqkmuZ66LOrGtYHaWAtgKiFxOZogpSOcAngKwA02ekqZn4Xsf3jt/HyDqT1IAmaQA0dQkAIimJgFANDUJAA0Jzn3E9COlqLV/Z0mORgGmVkUqRAJAMaG8DsofeMubw50OSjpYltkfkbQCXCDMtt6MvQQUFo+/jkQCwBEhPHnUEDVE/lqVHYxKAsAvBKN44/U36Qbak3GmOIyPn5XSzHv5UWf6UsZWCSvfjDQdAFBDyVvFfE+MA/5MNA0AFHpcBgTrWvFeaHgAYEZjz6qRGXHzI9OwANBWpy0Q9pSN9kzDAQBBxrN5dHoxbrdHu2gbCgDa7vQBAqqGj0LDAEC11fquBnufCvFC4QFg/dibeH0M4E6OviUKDQAMvnz6fJBaPHLVi8ICQMbPN/wRQJCibntUT4Fv9COAICQAFMPDN/Zz3OvJ96kBgAsZtqLF44RQpGgRnDI+/wCMlLIZCgCqHsU37tzEmygUBgB6SIJv2CUcJRUzDAD0giLfqGvrD3qmMADQSzZ8o27xQKM3CgEAHX75Bj3qYTgEAK6vr+nKFI+ZXhkCAJhJZIDxQBghbDoEABTnzzdmAYBIWgH4xiwACAB0g4rGOgM0JMX98w26lOG88E4hzgAgRYDyDXrEyNAwANBBmG/UJXz/0/tskxkLACAlwfANO5dxeRmBQgFAuQB8wx4tJyAUAECKCeIb+BbDWYGU1SgUDgAKi+AbeXTXZ2gAgBBrzla0+HQMUIE7GoUEAEheIV8gjOL1GQYAINX85xs+GGUpo1JoAIAw87ANYGaObPxDAGB5C4BtCDNyhHDnKQAAwsWLiuT2MXy4OiPE+UwFgIXwpA97ZhyZI5U8mRIAS/6AokfbG/+IzyQNCYCFVEqljeFHKXFSQ0MDYCFVlKszfISgRwprqKEpALAQvBbsPXQEnsHwpwTAQvBg6CXJu0aPUPMIdXxa05QAOKSHD79//tKLL9NnXRaP4MufGgCYzY/TJWteN8eSP4sLFeNV87jdcfwVVtGrq6vi73iiFPXmN+fSa89eFivDKBlokGNPpGbOxIBVVNGgRgQjxlJd69vH7+2NUwcgoiTjYHKAvHsOspjZ90wAAE2EtEjXKwAOZa1nYSzbrR5zQ14CXKysMwTaRfutavFjW/TuO+817SMmH88XaO4AgFmj16vvABdmdgsCyABgXMZh9YJhgS95nzB7Lz+L38O2At/BAyEWhJm+l0cMr8tbyREeADBEdvgCZtNRgry2ZnmEkLPH2ov3iQoA7FE9F7zCShTlqZ+tGd7zTThWBeZZgQIA74a/xdguYFvj7VFobC2w145yUPcChK4AiGz4uWeKZe8OY8TevUVIAb6DLSK+i/EbOe8BsvU8J3QBwOiGL44LBHMA9PLoiMccA2w5LQPzzACg2j184xmJce4KAQCgVZGWfIMZkXHx13pb1BQAysDiG8kM3LIUSxMAAJUzhxSLOWOAoEg6AFSiUABgTgA1oe/NAOD5hlE8zxjgEq0rAHTQ5StdfHcMENtUk+STavb77EAqscZgzQZKY7eKACDfvgwvwuTz4LMH7QEg4+crVtweBCk3GEuDLwOMZgM5OcoXAYCwX7YgYo1BrQ1cygVPlw68Mj4Z38gH41UAwKUkbw9feeI2Y7BWv2gVAApok/HN8H7xWQAoqI2vMHGfMu8nANC+X8Y3UwDdCQBaF0YSaww82QCillcBgERudgfFGoOeEaS3AEBJCnl9ZHyzeYVuAaBX1/lKEfcbA4Ty3wEAYqqlABnhTDYAt+gNALAcsDsj1hj0tgGceW8AoMwuGd+MExB2PQnLgA6/fGWIOWOQlNQu45sZfEnhznwliIkAwBlA2V4ywhlBiIdC0nEQnM4DfMWI7W+Cl8jQlJMOKdYYRLaBrerSbt4IE4kYJACIpqafAQAA///P0oMoAAAABklEQVQDABsGcURyYgp8AAAAAElFTkSuQmCC",
            'dual' => null,
            'first_login' => $fakerSpain->boolean,
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
