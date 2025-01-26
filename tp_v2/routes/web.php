<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\ResponsiblesController;
use App\Http\Middleware\AdminRoutes;
use App\Http\Middleware\StudentsRoutes;
use App\Http\Controllers\PPSController;
use App\Http\Middleware\RespRoutes;
use App\Http\Middleware\TeacherRoutes;
use App\Http\Controllers\WeeklyTrackingController;
use App\Http\Controllers\FinalReportController;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pps', [PPSController::class, 'index'])->name('getPps');
    Route::get('/pps/details/{id}', [PPSController::class, 'details'])->name('pps.details');
    Route::post('/pps/approve/{id}', [TeacherController::class, 'approveApplication']);
    Route::get('/pps/downloadWorkPlan', [PPSController::class, 'downloadWorkPlan']);
    Route::get('/pps/{id}/weeklyTracking', [WeeklyTrackingController::class, 'index'])->name('getWeeklyTrackings');
    Route::get('/weeklyTracking/{id}', [WeeklyTrackingController::class, 'details'])->name('wt.details');
    Route::get('/finalReport/{id}', [FinalReportController::class, 'details'])->name('fr.details');
    Route::get('/pps/{id}/resume', [PPSController::class, 'finalResume'])->name('resume');
    Route::get('/pps/{id}/resume/wp/download', [PPSController::class, 'downloadWorkPlan'])->name('wp.download');
    Route::get('/pps/{id}/resume/fr/download', [FinalReportController::class, 'download'])->name('fr.download');
});


Route::group(['middleware' => ['auth', AdminRoutes::class]], function () {


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

    //teachers
    Route::get('/users/teachers', [TeachersController::class, 'index'])->name('getTeachers');
    Route::get('/users/teachers/create', [TeachersController::class, 'create'])->name('createTeacher');
    Route::post('/users/teachers/create', [TeachersController::class, 'store'])->name('storeNewTeacher');
    Route::get('/users/teachers/edit/{id}', [TeachersController::class, 'edit'])->name('editTeacher');
    Route::post('/users/teachers/edit/{id}', [TeachersController::class, 'update'])->name('updateTeacher');
    Route::delete('/users/teachers/delete/{id}', [TeachersController::class, 'destroy'])->name('deleteTeacher');
});

Route::group(['middleware' => ['auth', StudentsRoutes::class]], function () {
    Route::get('/pps/new', [PPSController::class, 'new'])->name('pps.new');
    Route::post('/pps/create', [PPSController::class, 'create'])->name('pps.create');
    Route::get('/pps/edit/{id}', [PPSController::class, 'edit'])->name('editPps');
    Route::post('/pps/edit/{id}', [PPSController::class, 'update'])->name('updatePps');
    Route::delete('/pps/delete/{id}', [PPSController::class, 'destroy'])->name('deletePps');
    Route::post('/weeklyTracking/{id}/saveFile', [StudentsController::class, 'saveFileWT'])->name('wt.saveFile');
    Route::post('/finalReport/{id}/saveFile', [StudentsController::class, 'saveFileFR'])->name('fr.saveFile');
});

Route::group(['middleware' => ['auth', RespRoutes::class]], function () {
    Route::patch('/pps/tomar/{id}', [PPSController::class, 'tomar'])->name('pps.tomar');
    Route::post('/pps/assignTeacher/{id}', [ResponsiblesController::class, 'assignTeacher'])->name('assignTeacher');
    Route::post('/pps/{id}/weeklyTracking/generate', [WeeklyTrackingController::class, 'generateWT'])->name('wt.generate');
    Route::post('/finalReports/{id}/create', [FinalReportController::class, 'createFR'])->name('fr.generate');
    Route::post('/finalReports/{id}/finish', [ResponsiblesController::class, 'finishWholePPS'])->name('fr.finish');
});

Route::group(['middleware' => ['auth', TeacherRoutes::class]], function () {
    Route::post('/pps/editObservation/{id}', [TeachersController::class, 'editObservationPPS'])->name('pps.editObservation');
    Route::post('/pps/approve/{id}', [TeachersController::class, 'approvePps'])->name('pps.approve');
    Route::post('/pps/reject/{id}', [TeachersController::class, 'rejectPps'])->name('pps.reject');
    Route::get('/studentsReport', [PPSController::class, 'downloadStudentsReport'])->name('studentsReport');
    Route::post('/weeklyTracking/{id}/editObservation', [TeachersController::class, 'editObservationWT'])->name('wt.editObservation');
    Route::post('/weeklyTracking/{id}/approve', [TeachersController::class, 'approveWT'])->name('wt.approve');
    Route::post('/finalReport/{id}/editObservation', [TeachersController::class, 'editObservationFR'])->name('fr.editObservation');
    Route::post('/finalReport/{id}/approve', [TeachersController::class, 'approveFR'])->name('fr.approve');
});



require __DIR__ . '/auth.php';
