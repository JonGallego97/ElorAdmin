<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\CycleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\FirebaseController;

use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\ModuleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resources([
    'departments' => DepartmentController::class,
    'roles' => RoleController::class,
    'cycles' => CycleController::class,
    'users' => UserController::class,
    'modules' => ModuleController::class
]);

Route::put('users/{user}/update-password', UserController::class.'@updatePassword');
Route::post('/users/{userId}/enroll/{cycleId}', [UserController::class, 'enrollStudentInCycle']);

//FIREBASE
Route::get('/firebase/fmcTesting', [FirebaseController::class, 'fcmTesting']);

Route::post('forgotPassword',[AuthController::class,'resetPassword']);
Route::post('password/email',[ForgotPasswordController::class,'sendResetLinkEmail']);



//Auth
Route::post('login',[AuthController::class,'login'])->withoutMiddleware(['auth:sanctum']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');