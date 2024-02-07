<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

    

    /**
    * @OA\Get(
    *   path="/api/v1/reto/version",
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
    * )
    */ 
class RetoController extends Controller
{

    
    public function whatVersionAmI(Request $request){
        return response()->json(['message' => 'Esto es API v1'], 200);
    }
}
