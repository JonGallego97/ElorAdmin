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

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum','verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/set_language/{language}', [LanguageController::class, 'setLanguage'])->name('set_language');

Route::prefix('admin')->middleware(['auth', 'checkRole'])->group(function () {
    //Users
    Route::get('users/{user}/editRoles', [UserController::class, 'editRoles'])->name('users.editRoles');
    Route::put('users/{user}/editCycles', [UserController::class, 'editCycles'])->name('users.editCycles');
    Route::delete('users/destroy/{userId}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/students', [UserController::class, 'indexStudent'])->name('students.index');
    Route::get('/teachers', [UserController::class, 'indexTeacher'])->name('teachers.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/{userRoles}', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/extra', [UserController::class, 'extra_create'])->name('users.extra_create');
    Route::resource('users', UserController::class);
    //Roles
    Route::delete('roles/destroyRoleUser/{roleId}/{userId}', [RoleController::class, 'destroyRoleUser'])->name('roles.destroyRoleUser');
    Route::delete('roles/destroy/{roleId}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::resource('roles', RoleController::class);
    //Departaments
    Route::delete('departments/destroyDepartmentUser/{departmentId}/{userId}', [DepartmentController::class, 'destroyDepartmentUser'])->name('departments.destroyDepartmentUser');
    Route::delete('departments/destroy/{departmentId}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
    Route::post('departments/create', [DepartmentController::class,'create'])->name('departments.edit_create');
    Route::resource('departments', DepartmentController::class);
    //Modules
    Route::delete('modules/destroyModuleUser/{moduleId}/{userId}', [ModuleController::class, 'destroyModuleUser'])->name('modules.destroyModuleUser');
    Route::delete('modules/destroy/{moduleId}', [ModuleController::class, 'destroy'])->name('modules.destroy');
    Route::resource('modules', ModuleController::class);
    //Cycles
    Route::resource('cycles', CycleController::class)->except(['delete','create']);
    Route::get('cycles/getCyclesByDepartment/{department_id}',[CycleController::class,'getCyclesByDepartment'])->name('cycles.getCyclesByDepartment');
    Route::controller(CycleController::class)->group(function () {
        Route::get('cycles/create','create')->name('cycles.edit_create');
        Route::delete('cycles/destroyCycleModule/{cycleId}/{userId}','destroyCycleModule')->name('cycles.destroyCycleModule');
        Route::delete('cycles/destroy/{cycleId}','destroy')->name('cycles.destroy');
    });
    // Route::delete('cycles/destroyCycleModule/{cycleId}/{userId}', [CycleController::class, 'destroyCycleModule'])->name('cycles.destroyCycleModule');
    // Route::delete('cycles/destroy/{cycleId}', [CycleController::class, 'destroy'])->name('cycles.destroy');
    // Route::resource('cycles', CycleController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/person/{user}', [PersonController::class, 'index'])->name('person.index');
    Route::get('/person/{user}/staff', [PersonController::class, 'staff'])->name('person.staff.index');
    Route::get('/admin/departments', [DepartmentController::class, 'indexPerson'])->name('person.departments.index');
    Route::get('/admin/cycles', [CycleController::class, 'indexPerson'])->name('person.cycles.index');
    Route::get('/person/{user1}/staff/{user2}', [PersonController::class, 'staffShow'])->name('persons.staff.show');

});
Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

