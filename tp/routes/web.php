<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\TeacherController;


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

Route::get('/welcome', function () { return view('welcome');});

Route::put('/usuarios/alumnos/edit/{id}',function(){
    return 'hola';
});
//alumnos
Route::get('/usuarios/alumnos', [AlumnoController::class, 'index']);
Route::get('/usuarios/alumnos/create', [AlumnoController::class, 'create']);
Route::post('/usuarios/alumnos/create', [AlumnoController::class, 'store']);
Route::get('/usuarios/alumnos/edit/{id}', [AlumnoController::class, 'edit']);
Route::delete('/usuarios/alumnos/{id}', [AlumnoController::class, 'destroy']);


//TEACHERS 
Route::get('/usuarios/teachers/create', [TeacherController::class, 'create']);
Route::post('/usuarios/teachers/create', [TeacherController::class, 'store']);


Route::resource('pps', 'App\Http\Controllers\PpsController');
