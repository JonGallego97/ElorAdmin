<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\CycleController;
use App\Http\Controllers\API\UserController;

use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\ModuleController;

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

