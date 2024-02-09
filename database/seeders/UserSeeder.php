<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Department;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Alumnos - Deben de ser 1000
        RoleUser::factory()->count(1000)->create(['role_id' => "3"]);
        //Profesores - Deben de ser 80
        RoleUser::factory()->count(80)->create(['role_id' => "2"]);



        $teachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'PROFESOR');
        })->get();

        foreach($teachers as $teacher){
            $departmentId = Department::where('id','>=',5)->inRandomOrder()->value('id');
            $teacher->update(['department_id' => $departmentId]);
        }

        DB::table('users')->insert([
            'id' => '0',
            'email' => 'admin@elorrieta-errekamari.com',
            'password' => Hash::make('Admin'),
            'name' => 'Admin',
            'surname1' => 'Admin',
            'surname2' => 'Admin',
            'DNI' => '12345678A',
            'address' => 'Dirección',
            'department_id' => 1,
            'is_dual' => false,
            'phone_number1' => 123456789,
            'phone_number2' => 987654321,
            'image' => "/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAoHCBUWFRgWFRUYFRgYGBgYGBgYGBERGBgYGBgZGhgYGBgcIS4lHB4rHxgYJjgmKy8xNTU1GiQ7QDs0Py40NTEBDAwMEA8QGhISGjEhGCExMTQxNDE0NDE0MTQ0NDE0NDQ0NDQ0NDE0PzQ/PzQ0MTQxPz8xNDExNDE0NDExMTExNP/AABEIAOEA4QMBIgACEQEDEQH/xAAbAAACAwEBAQAAAAAAAAAAAAADBAECBQAGB//EADcQAAEDAgQEAwcDBAIDAAAAAAEAAhEDIQQxQVEFEmFxgZGhEyIyUrHB8BTR4QYVQvFichYjkv/EABgBAAMBAQAAAAAAAAAAAAAAAAABAgME/8QAHxEBAQEBAAIDAQEBAAAAAAAAAAECERIhAzFBE1EE/9oADAMBAAIRAxEAPwDznPKNgmAknZZ9N5K1OGMzPULn+P3qNNfRxlKdB6K5aAMh5I1Nh0WnhuAPqCT7o6rujGvO1HiZiPBRhsI+o4NY0u3gWXvcH/TFBoHO3nO7rDyWzTwoYIYxrQNgAnaJl5PAf00wAGoZ6LVbhKbBZggawD6LWOHMyPVXGGBClfGFVEj3AIPTXsgDDvIgtAvnA9QvQ/pY7XzAUOw40F9R90DjAdg3EzAO8NEdFb9FJgtneBbrK3RS1HopZKRsD+1GIsNrSmGcOgQGhx1my2mgBSyEujjNZgJFwWnTIpg4IatDusAQdwnWmQoIidigcLnBNMSIPYQjMwQGX0CKx9h/tX5kGEMJ2PgERmGA0HkERj0TmTCraA2HkFcUxsPIKzXqeZMKim35R5BTyN+UeQVwVKAE6mPlHkFIpt+UeQRFCAwOKODHmwuBoEs2qyMh5BanG8PLeaLgLxeJxTmnlIhcPzWzRxu+2ZsPIKF57253UrLzN4Ck6F7XgHBXvaCGwDrkF6Dgn9D0KMOqf+14MgkQ0dhqvVMaAIAAHSy7Pj+Pxvam+2PgOBMZd3vFa3sgMlIKmVuXEcq6VQEyVxCA4noqkhWCgoDnGVDR0upaPBWDOqRhCnA1UNYjwNVwagBckzoqtYRfNMAKQ1LgCDbK3Ii8iu1qOAFtMK3s0YMVgxVwABkKwajcqkNRwBgFTBRFMICgCkKVyA5crKEBBSuJ4bSf8bAfRNqErmX7DG/8Yw/ynzK5bK5T/PP+DpEuUFSHLpVE5qkhdGy5MIDVymFIQaOVTC6V0pBHKrBqiV3MmE8iuGqgKtzJhPKrtYoC4PQFgxWDVX2ig1Rul2ARSgnEt3VTi27o7AYXJR+MbuuOMbul2A2ulJHFob8YQl5QNFcss8SG6E7jLRm4I8oG0uWEePMn4godxxnzDzCfQ3lCxRxtnzj0RG8YZ848wjoay5ZX93Z848wuR5QcSHqOZLNqjQqG15N4CE9O+0VjUSPtgMyln8QE2KD603vKoHlZo4iSDF4QafE4Ikwjo62y9VdVACyH8WExPika/FdCUh16MYobqP1jd14/E8T2JKzncScDMp8o693/AHJupXHiY0Xz9/FyVz+LnlIBgo5R17x/FYEylK3GI1XgWcacZDjkqP4mTqjheT3zOOSLmFYcTB1Xzt2PMZlcziDxlJU3k/VTyv49/ieKNAs5JnjIyn1XiWV3uMXRHUX7lRd5n6qY1fx6jE/1A1pzSNX+p3TZedfR1cUnXxAbbNT/AFiv52fb0n/lb57KKv8AVT3ZGF5GpjBokatZx1gIm03PHrK/H3kn30hV4y4/5eq86Hm6kGUeSedbbuMO+ZU/uzvmPmsh4jNdCJoeLXfxJwvznzQxxx3znzSAyhI1qcFVKVb/APenfOfNcvN865UXX2CrxprXiZuurcYuCHQF42rjXOu/TJLuxogiYV9hcr22I4ubQ6UqeKZz9V5CnxCbXKlmIJKnykPxr1TOOFsgGEu7jNt154PlTzKdfLIufHa2jxcxEoJ4o4ndZBcjUGSo/sqfCfPEzsgnFE3hFZhAUduFhK/PVz/nZz67uqAK5W4ymDYtHkqVcAzPl8rKL81q/wCEjMosE3Oa08NhGOCXdhwMiiMxQYIGZUX5L/qs4zPwWjSEm2RTDWDQKMMy07ohCi6tbTMkAwLhzlXx1cjKyQqVeR86HNGOKY7WVMpVl4mo9xtKTdhXn/Er0FMjQKx5lU1E347XlzhXC5ahmnuF6v2LjaEF+BGwTnyM9fC8tXpOjJVoUzqt/E4KJhZL2wYWk11nrPirXbkEFmUbJuqy06oDGK59M6pzLqwkW/0oqiDOW4VeZVE0tylSj8wXJ9LjQr1iZPgB91nPaZ+qbqkA27JR5v8AdKHTFA6DLUptjpsPFZzH3geabpmCIRpWTbWqHIpyQysLfbeT0tSZJ3T5axgl742GqUw5eMoKI5nOffuR6BJc9Odx1osxhcetglq/GMS4e60N6RzDpdNM4eNBZMN4fGSJqT8Px1f1ns4lVAvIMf8AGJ/ZSONPHxCUy7hm7vuhv4c0dUXUv4Uzqfqv9xa+TkUGnULnSMgqV2NAiENr+UW8UuQu1s/3KBErqOP6rGdJVqcylxXlWpXqhzTKQpuDRJRmMtCE5saSESC+1X8VebMEd0Bz8S6CHnqBayabhgb5J/DYLUOR5SfheOr+s1mIxDDYOjZ0O9Uzh+Ov/wA6fct/YrVOEkX9ErWwQCLqf4czqfooe17ZYViYpkOT1HmY6QLHPRAxjZPMLTmEZs6WvcIVckung0apPEUzOfZbZ+nPqe0B02KC9hCIBur83irQWhQmIXJku8DM3SVaoFavUjr9Em+SnILRBXJsLLUpCAFl02QtMOJhLSsNBvwqsK7DLY6LmMuueuiex8O2TAt1RnhrTlLs4zPiupe6LZlWZSueqnrSQaniQQOYhvQSjsqNnMkJRtKFJKXVw7Ve0ZJDEV5VKjtUs6ogtUOo3zQPZXR2tJK5zoVdZ2KsbdHbRulmvunaNTdFKJLLwitYNVVzrphjZCm1cirGAdkxT5OyEBCkNCmqh4VCLH3hvkUOu1puLeqExzspV2NLkjL1W6HI/kpPGUY/M1pOp8puLIGIZIjUZdkfVTcsaowhkrM5zN1vOYC3lOs/wsXEUxN7HU/RdGa5tOa5p8lzqZEIIbGe6Ox8mDdaMlI6Lk37Nm5XIDHruCmnSm5CltOXTomQyLlVaUijWAXJRAf4QiSSmMoUqh7CusmGMuksK76rSohY7dGPZhjdUZqhoUOKz634o982VHC1kZlJFbQSVwgWWuoZhdStNmFGqy+M1yIY3VVInU5Oo9uzIeaVqiUr7MpmncKucZd6ExslPMp7qlCndPsYlaeYHUZayNhnxnoiuomEpEShX01qHI+QM9iudhC3RZAcWkPGmfUL1GFqh7Ql6Vn2y2sTGHHSE+/B6hCfThLx4sniISFb6JuuUtUbIUfqb9EXssk6lAOz/wBjr1Wk2mSI8u6C9mh8lvly6ntjV8NplsdD/KSbNzqB91u1aZuNNFlY1kOn8laysbHc53KlR7boFKZF6LdUR5nRTTGQ8SjuAi1uuqdBdlPInS/7KObqiloGZ81VsbJHBsMb2WthjN1lMMd1qYN1vqsdt/ivs40K7G3VG5orHXWMdRulTTTKQS1HNO84bmrhyFcUOUWXnalMufJ3WvjKxcbJXlTTqz6DfghCXbhoKeZiBk7zCMaYNxcIRyUtQoJulRuiYcCYTjKOyUVziPY2WZiKYlbVcwFm8nM6yY4DQw/NZP4Mchg6J/AYVrbuziw26pXG04dzDxCNZ9dPN9tVr7JTFImGfLVSuot9NOMis1B2R64QH07bSoz21G7yF2N5TEyChveNv4RazIv5j7pKqF0OWrloI7rK4oyIPUjwWkG2slOIyR2H+1pllohyj8lSrQNlyrqUYanIRnOA7/mSmkwNaIzOau1skjw0RRIXJB0n1UJh7Q2wuqPZb6pHAWm6dw9WElYZDNGpgqdfS83la9GrICYlZ1F8ALRYZXNZyurOjmGcc0R7S4wuwdOc7AKcS4kAAxP0Wucr1ou8AWALihupHWycpUSBA81P6QkXV8YW9ZhpwrsdCefhgBAEkoT8P4qbk5UYZ03Wix4jqkWM5U1TaLT4qecaSrVnzYaq9GkGdzqps0SN7IdQlwI8QU5CtHfU/hDqy4dVRjjqLp1lJUnpbBkix2RsSbSoDb9W59RK7ENtY+Cy1njbOuxmPuVSv8I8UXlSmJfZsZxcZpYyy+TRZhIs7LQ7IL2QYRWEAXNjlqquaVs56uylDSRpl/CzcY+Tda7He7HrnE79FnYpoGmvoVUTfpm+27KE7+kZ8pXKkBOqWA1KsTFhmUjz3MHOwTzB6NCfBFKj+XLMpdpJkbdUSuZdsP2XUmw2dTdI1C2IkX1V6Z6/mqqSSZy9bdVcMAyupqoOx+i08G6QsmgyStfDiLDYLOxtnTapn3OqpToczpOQRMOJCZAhVF2qmAq809lzmQCSsDiHFn03ABgLebM5gKkvQch1t0V6jAGneyxWccw4e1vMS5xvnA7rSo4qm93K14vNsohF6csoXsXOd0EXR30sgN1TEy0EhzQALhc2k8xDhoc1FXODVWWA8EKiwzBK6nSc8uBdAbadyhfq6LHua+q0OGhMW3RO0auZ+tSnTBaD1TQZB8EpgMSHsaWZGD4aI4fnuDHhZWyqlWl73MNiCk8SeUT4LU5bLK4mZluVgQVnuNM69FXPz6/g+yysQSHSmXVtDll+xS9YgiNUoz1eguqZ2CtQrRmLTkqsH7H7K3OMgI6rSM6ZcQL5gzH59lQ4dpE6TI/Y7KlE73BmUyAYHUQe+iqJpTlKlH5zsFKonlqFPQ/kp4siwQsPTvJ7x9EfEtJIA7k/ZFpSANZJtdE9kZvYQrtpwIAganVWt3UnAvZHwXZC+SI+/wAR8AqhoGtkjiMI0OnTRalB2g6BJsZ7pIW7wvDNaBaXETfJLi4doN5QJ7qebXf6IdU80dCZ8lD9B2Q0g2OdDe5lYeNpBwM3Wnj6uQS1Vo5R1Uavtpn648ZjsEQZbmDIOS5jzm7mEnPdegqYWT3Q63DZby6G6qb7OVF+H32MttVpzd5kob8UQfdeR2JCdZwkNzZzeJUnCEiPZiJsdk+xPjtm1OJPAMPdJ0DjdCweDfUeHPkjrqvR8P8A6eFiR1krWwuADdOyd1z6hz4v2jcGYWAX0WvTqAkiMoPmkmMt0CNRdBcd1nKu5h5rjMbBZ+Op84tnkmRUt1BQ338VV9o+nncUy+x9DGqznk3PotzH0om1xn1G6yKrIMqbEVRr5idkenRJFtEsKRm2RyWthaZgH/R3CeSD9laRvHabI9Me76HeRqEWuyGmB4dj/KqwTMfNPpf6rSIoPL2XIv6ft5rkyYeGo/5OQazi5+eV7egTGJq3DRkIS7rc56f7QBKLJ5ifyFZjbAm5MlWwjPdAnw6RJU1MvSPBIKFtpt9ZQg2T8KbpsMAnKTA1MZ+Ckv6JWKi1NkNErawj5J0vHhFlkMNj0v55rUwEGC3P6j9xdEVBKYIJbGUEHwK7EP5XXFs+6ZqNmC3sR1Q8RT52/wDJl43aUWLzWZWdzEk9FMgxpKhnVQ0jyghZ8adcXNy6ozaYST4I2lc2qW62WfGk1xosp7lFZTaNQs1ry7PL90zT72VS05qHmPGiMRbqlMIYJ2lExNaAdwn0rR8RZtkOkZpwTGs/n5ZKOxHNbe/hrKI53ukDuOsXS6im/aZGQVxG3Uxssejib210WtWHwxnEHvdXm+mWqXqVxadBB+xWViaXvcwvfJNYiSZzlo+yCJBE6+qLepCpUocW9Q4diD+y06TwBGhuO4mfsgGlkci0+kyFzHaHeEwLVfF9Psc0KjmNPpOihwjPx81xB5IBJt9/zyVRFFgLklyP39QpVF1jugEk7epVBJe4aACduy57TzXubGPMlGYItq73j20+yZCUnw76+SLiWAv5RciHD7oVBkNcTnkEzSJc8RnDf3KDi4zI1AA9JK5/K3Se6G55a4CZJN+38qlVpDj0lRVCh0ZRcemSNRdyZGLg+qphWWcQJsYRC33esAeeaDh2tjgNoN/FNMxQ9x7TYnlcFg4lhMNByud9locOonkDf+YPgM0S3qhsdSAd0E+RWe86BaPEPeJIs39lnQSbQAp1FSla7iO+qA+uJuUfFU8yLrJr0jPgo4La1KeKEAp3DYoEwvP0GO8E7ht+qmqzpt/qALalL1Kp5gTl90JwJuMwiMEi+6XRauXXvbMeBUVKxDYByi6DiGGZ3QxOuyfBaNRfLgYvOa3g27zmABH/AMrzVJ/K4d16kuAEauhx7WH0WmWdJVKQaBuQT2EwFTE0Rb/j/r6fVMYj3p3DCPHmQnvB5genkYH2ToCe+5H5khMFyVLG7m9vRHNKR9eyCUcybi4tZR7QEm2QyyhEDIba9suiqylzHLSJ+iqEH7I9VKN+gd19VyY48afj81ZvxnsFy5aMTWg/NUXC/EOxXLkjgX+ZV6nxHsuXJGNR+FFbp3+65ckcD/zd3K18D8AXLkRRXE5Jb/ErlyKC4+HwSlbRcuWZuciUcvH7rlyBD7fspbl4rlyUVfp1T4R4pdv2XLk0qfut+tm3/qFy5VBUnN/Y/VL18z/1ClcmA2a9kZua5cgJp5j80Kvgsx/2auXJk2Vy5cmH/9k=",
            'first_login' => false,
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
