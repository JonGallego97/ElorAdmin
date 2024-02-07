<?php

namespace App\Http\Controllers\API\V2;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

    /**
    * @OA\Get(
    *   path="/api/v2/reto/version",
    *   tags={"Reto"},
    *   summary="Shows Reto",
    *   @OA\Response(
    *       response=200,
    *       description="Shows Reto."
    *   ),
    *   @OA\Response(
    *       response="default",
    *       description="Error has ocurred."
    *   ),
    *)
    */    
class RetoController extends Controller
{

    
    public function whatVersionAmI(Request $request){
        return response()->json(['message' => 'Esto es API v2'], 200);
    }
}
