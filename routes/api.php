<?php

use App\Http\Controllers\API\V1\PasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\DepartmentController;
use App\Http\Controllers\API\V1\CycleController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\FirebaseController;

use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\ModuleController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\RetoController as RetoControllerV1;
use App\Http\Controllers\API\V2\RetoController as RetoControllerV2;



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

URL::forceScheme('https');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth'], function() {
    Route::group(['prefix' => 'auth'], function() {
        Route::post('logout',[AuthController::class,'logout']);
    });
});

/* Route::put('users/{user}/update-password', UserController::class.'@updatePassword');
Route::post('/users/{userId}/enroll/{cycleId}', [UserController::class, 'enrollStudentInCycle']);


//FIREBASE
Route::get('/firebase/fmcTesting', [FirebaseController::class, 'fcmTesting']); */


Route::group(['prefix' => 'v1'], function() {

    Route::post('/password/reset', [PasswordResetController::class, 'sendResetLinkEmail']);
    
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resources([
            'departments' => DepartmentController::class,
            'roles' => RoleController::class,
            'cycles' => CycleController::class,
            'users' => UserController::class,
            'modules' => ModuleController::class,
        ]);

        Route::post('logout',[AuthController::class,'logout']);
    });

    /* Route::put('users/{user}/update-password', [UserController::class.'@updatePassword']);
    Route::post('/users/{userId}/enroll/{cycleId}', [UserController::class, 'enrollStudentInCycle']); */

    Route::group(['prefix' => 'auth'], function() {
        Route::post('login',[AuthController::class,'login'])->withoutMiddleware(['auth:sanctum']);
    });
    /* Route::group(['prefix' => 'roles', function() {
        Route::resources(['roles' => RoleController::class]);
    }]);
    Route::group(['prefix' => 'departments', function() {
        Route::resources(['departments' => DepartmentController::class]);
    }]);
    Route::group(['prefix' => 'cycles', function() {
        Route::resources(['cycles' => CycleController::class]);
    }]);
    Route::group(['prefix' => 'users', function() {
        Route::put('/{user}/update-password', [UserController::class.'@updatePassword']);
        Route::post('/{userId}/enroll/{cycleId}', [UserController::class, 'enrollStudentInCycle']);
    }]);
    Route::group(['prefix' => 'modules', function() {
        Route::resources(['modules' => ModuleController::class]);
    }]); */
    Route::group(['prefix' => 'reto'], function() {
        Route::get('/version',[RetoControllerV1::class,'whatVersionAmI']);
    })->withoutMiddleware(['auth:sanctum']);
});


Route::group(['prefix' => 'v2'], function() {
    Route::group(['prefix' => 'reto'], function() {
        Route::get('/version',[RetoControllerV2::class,'whatVersionAmI']);
    })->withoutMiddleware(['auth:sanctum']);
});

