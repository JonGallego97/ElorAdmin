<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

URL::forceScheme('https');

Route::get('/', function () {
    return view('auth.login');
});


Route::middleware(['auth:sanctum','verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/set_language/{language}', [LanguageController::class, 'setLanguage'])->name('set_language');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'checkRole'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    //Users
    Route::get('users/{user}/editRoles', [UserController::class, 'editRoles'])->name('users.editRoles');

    Route::get('/students', [UserController::class, 'index'])->name('students.index');
    Route::get('/teachers', [UserController::class, 'index'])->name('teachers.index');
    Route::get('/withoutRole', [UserController::class, 'index'])->name('withoutRole.index');
    Route::get('/personal', [UserController::class, 'index'])->name('personal.index');
    Route::put('users/{user}/editCycles', [UserController::class, 'editCycles'])->name('users.editCycles');
    Route::put('users/{user}/addCycle',[UserController::class,'addCycle'])->name('users.addCycle');
    Route::put('users/{user}/addModule',[UserController::class,'addModule'])->name('users.addModule');
    // Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('users/destroyUserModule/{module}/{user}',[UserController::class,'destroyUserModule'])->name('users.destroyUserModule');
    Route::delete('users/destroyUserCycle/{cycle}/{user}',[UserController::class,'destroyUserCycle'])->name('users.destroyUserCycle');
    Route::resource('/users', UserController::class);
    //Roles
    Route::delete('roles/destroyRoleUser/{roleId}/{userId}', [RoleController::class, 'destroyRoleUser'])->name('roles.destroyRoleUser');
    //Route::delete('roles/destroy/{roleId}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::resource('roles', RoleController::class);
    //Departaments
    Route::resource('departments', DepartmentController::class);
    Route::controller(DepartmentController::class)->group(function () {
        Route::delete('/departments/destroyDepartmentUser/{departmentId}/{userId}', 'destroyDepartmentUser')->name('departments.destroyDepartmentUser');
        //Route::delete('/departments/destroy/{departmentId}', 'destroy')->name('departments.destroy');
        //Route::post('/departments/create','create')->name('departments.edit_create');
        //Route::get('/departments','index')->name('departments.index');
    });

    //Modules
    Route::delete('modules/destroyModuleUser/{moduleId}/{userId}', [ModuleController::class, 'destroyModuleUser'])->name('modules.destroyModuleUser');
    //Route::delete('modules/destroy/{moduleId}', [ModuleController::class, 'destroy'])->name('modules.destroy');
    Route::resource('modules', ModuleController::class);
    //Cycles
    Route::resource('cycles', CycleController::class)->except(['delete']);
    Route::get('/cycles/getCyclesByDepartment/{department_id}',[CycleController::class,'getCyclesByDepartment'])->name('cycles.getCyclesByDepartment');
    Route::controller(CycleController::class)->group(function () {
        Route::delete('/cycles/destroyCycleModule/{cycleId}/{userId}','destroyCycleModule')->name('cycles.destroyCycleModule');
        //Route::delete('/cycles/destroy/{cycleId}','destroy')->name('cycles.destroy');
        Route::get('/cycles','index')->name('cycles.index');
    });
    // Route::delete('cycles/destroyCycleModule/{cycleId}/{userId}', [CycleController::class, 'destroyCycleModule'])->name('cycles.destroyCycleModule');
    // Route::delete('cycles/destroy/{cycleId}', [CycleController::class, 'destroy'])->name('cycles.destroy');
    // Route::resource('cycles', CycleController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/cycles', [CycleController::class, 'index'])->name('cycles.index');

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

