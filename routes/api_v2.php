<?php

use App\Http\Controllers\API\V1\AuthController as V1AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V2\AuthController;



use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resources([
    'departments' => DepartmentController::class,
    'roles' => RoleController::class,
    'cycles' => CycleController::class,
    'users' => UserController::class,
    'modules' => ModuleController::class
]);

Route::put('users/{user}/update-password', [UserController::class.'@updatePassword']);
Route::post('/users/{userId}/enroll/{cycleId}', [UserController::class, 'enrollStudentInCycle']);

//FIREBASE
Route::get('/firebase/fmcTesting', [FirebaseController::class, 'fcmTesting']); */

/* Route::post('login',[AuthController::class,'login'])->withoutMiddleware(['auth:sanctum']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum'); */

$versionAPI = "v2";

Route::group(['prefix' => $versionAPI], function() {
    Route::group(['prefix' => 'auth'], function() {
        Route::post('login',[AuthController::class,'login'])->withoutMiddleware(['auth:sanctum']);
        Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
    });
});

