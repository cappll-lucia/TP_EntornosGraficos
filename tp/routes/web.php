<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
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


//STUDENTS
Route::get('/users/students', [StudentController::class, 'index']);
Route::get('/users/students/create', [StudentController::class, 'create']);
Route::post('/users/students/create', [StudentController::class, 'store']);
Route::get('/users/students/edit/{id}', [StudentController::class, 'edit']);
Route::delete('/users/students/{id}', [StudentController::class, 'destroy']);
Route::patch('/users/students/edit/{id}', [StudentController::class, 'edit']);

//TEACHERS 
Route::get('/users/teachers/create', [TeacherController::class, 'create']);
Route::post('/users/teachers/create', [TeacherController::class, 'store']);


Route::resource('pps', 'App\Http\Controllers\PpsController');
