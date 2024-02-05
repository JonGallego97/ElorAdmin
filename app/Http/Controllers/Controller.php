<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
* @OA\Info(title="ElorAdmin API", version="1.0"),
* @OA\SecurityScheme(
* in="header",
* scheme="bearer",
* bearerFormat="JWT",
* securityScheme="bearerAuth",
* type="http",
* ),
*@OA\Tag(
*     name="Reto",
*     description="CRUD of Reto"
* ),
*@OA\Tag(
*     name="Auth",
*     description="CRUD of Auth"
* ),
*@OA\Tag(
*     name="Users",
*     description="CRUD of Users"
* ),
*@OA\Tag(
*     name="Roles",
*     description="CRUD of Roles"
* ),
*@OA\Tag(
*     name="Departments",
*     description="CRUD of Departments"
* ),
*@OA\Tag(
*     name="Modules",
*     description="CRUD of Modules"
* )
*/

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
