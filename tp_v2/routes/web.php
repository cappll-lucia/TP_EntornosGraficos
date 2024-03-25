<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeachersController;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//teachers
Route::get('/users/teachers', [TeachersController::class, 'index'])->name('getTeachers');
Route::get('/users/teachers/create', [TeachersController::class, 'create'])->name('createTeacher');
Route::post('/users/teachers/create', [TeachersController::class, 'store'])->name('storeNewTeacher');
Route::get('/users/teachers/edit/{id}', [TeachersController::class, 'edit'])->name('editTeacher');
Route::post('/users/teachers/edit/{id}', [TeachersController::class, 'update'])->name('updateTeacher');
Route::delete('/users/teachers/delete/{id}', [TeachersController::class, 'destroy'])->name('deleteTeacher');





require __DIR__.'/auth.php';
