<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\ResponsiblesController;
use App\Http\Middleware\AdminRoutes;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {

//students
Route::get('/users/students', [StudentsController::class, 'index'])->name('getStudents');
Route::get('/users/students/create', [StudentsController::class, 'create'])->name('createStudent');
Route::post('/users/students/create', [StudentsController::class, 'store'])->name('storeNewStudent');
Route::get('/users/students/edit/{id}', [StudentsController::class, 'edit'])->name('editStudent');
Route::post('/users/students/edit/{id}', [StudentsController::class, 'update'])->name('updateStudent');
Route::delete('/users/students/delete/{id}', [StudentsController::class, 'destroy'])->name('deleteStudent');

//responsibles
Route::get('/users/responsibles', [ResponsiblesController::class, 'index'])->name('getResponsibles');
Route::get('/users/responsibles/create', [ResponsiblesController::class, 'create'])->name('createResponsible');
Route::post('/users/responsibles/create', [ResponsiblesController::class, 'store'])->name('storeNewResponsible');
Route::get('/users/responsibles/edit/{id}', [ResponsiblesController::class, 'edit'])->name('editResponsible');
Route::post('/users/responsibles/edit/{id}', [ResponsiblesController::class, 'update'])->name('updateResponsible');
Route::delete('/users/responsibles/delete/{id}', [ResponsiblesController::class, 'destroy'])->name('deleteResponsible');


});

Route::group(['middleware' => ['auth', AdminRoutes::class]], function (){
    //teachers
    Route::get('/users/teachers', [TeachersController::class, 'index'])->name('getTeachers');
    Route::get('/users/teachers/create', [TeachersController::class, 'create'])->name('createTeacher');
    Route::post('/users/teachers/create', [TeachersController::class, 'store'])->name('storeNewTeacher');
    Route::get('/users/teachers/edit/{id}', [TeachersController::class, 'edit'])->name('editTeacher');
    Route::post('/users/teachers/edit/{id}', [TeachersController::class, 'update'])->name('updateTeacher');
    Route::delete('/users/teachers/delete/{id}', [TeachersController::class, 'destroy'])->name('deleteTeacher');
});




require __DIR__.'/auth.php';
