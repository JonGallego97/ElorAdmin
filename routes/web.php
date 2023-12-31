<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CycleController;


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
    Route::get('users/{user}/editCycles', [UserController::class, 'editCycles'])->name('users.editCycles');
    Route::delete('users/destroy/{userId}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/students', [UserController::class, 'indexStudent'])->name('admin.students.index');
    Route::get('/teachers', [UserController::class, 'indexTeacher'])->name('admin.teachers.index');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::resource('users', UserController::class);
    //Roles
    Route::delete('roles/destroy/{roleId}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::resource('roles', RoleController::class);
    //Departaments
    Route::delete('departments/destroy/{departmentId}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
    Route::resource('departments', DepartmentController::class);
    //Modules
    Route::delete('modules/destroy/{moduleId}', [ModuleController::class, 'destroy'])->name('modules.destroy');
    Route::resource('modules', ModuleController::class);
    //Cycles
    Route::delete('cycles/destroy/{cycleId}', [CycleController::class, 'destroy'])->name('cycles.destroy');
    Route::resource('cycles', CycleController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
