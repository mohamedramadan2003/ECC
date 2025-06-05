<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\we\WeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExameditController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\Excel\ExcelController;
use App\Http\Controllers\serch\SearchController;
use App\Http\Controllers\viewExam\VeiwController;
use App\Http\Controllers\addexam\AddexamController;
use App\Http\Controllers\program\ProgramController;
use App\Http\Controllers\ShowExam\ExamTableController;
use App\Http\Controllers\subject\AddsubjectController;
use App\Http\Controllers\addexam\DeliveryexamController;
use App\Http\Controllers\subjectsPrograms\SubjectsProgramsController;

Route::middleware('auth')->group(function () {
//  عرض صفحة الرئيسية
Route::get('/', [HomeController::class , 'index'])
->name('home.index');

// عرض صفحة التسليم
Route::prefix('exams')->group(function() {
    Route::get('/{programType?}', [VeiwController::class, 'showExams'])
        ->where('programType', 'عادي|خاص')
        ->name('viewexams.show');
        });
        
Route::get('/viewexams/normal/edit',[VeiwController::class, 'index1'])
->name('viewexams.index.edit');
Route::get('/viewexams/special/edit',[VeiwController::class, 'create1'])
->name('viewexams.create.edit');
Route::put('/viewexams/update',[VeiwController::class , 'update'])
->name('view.update');
// عرض صفحة اضافة اختبار جديد

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')
->middleware('AdminMiddleware');

Route::get('/search/subjects', [SearchController::class, 'searchSubjects'])->name('search.subjects');
Route::get('/search/coordinators', [SearchController::class, 'searchCoordinators'])->name('search.coordinators');


Route::get('/deliveryexams',[DeliveryexamController::class , 'index'])
->name('deliveryexams.index');
Route::post('/deliveryexams',[DeliveryexamController::class , 'delivery'])
->name('deliveryexams.delivery');


Route::get('/delete-all-exams', [ExameditController::class, 'destroyAllExams'])->name('exams.deleteAll');

Route::delete('/viewexams', [ExameditController::class, 'destroy'])->name('viewexams.destroy');
Route::get('/addexams',[DeliveryexamController::class , 'create'])
->name('editdeliveryexams.create');
Route::post('/exams/store', [DeliveryexamController::class, 'store'])->name('exams.store');
Route::get('/viewexams/edit',[ExameditController::class, 'edit'])
->name('viewexamsedit.edit');
Route::post('/addexcel', [ExcelController::class, 'store'])->name('addexcel.store');
// we
Route::get('/wehave', [WeController::class , 'index']
)->name('we.index');
 // concat
Route::get('/concat',[WeController::class , 'create'])
->name('concat.create');
Route::post('/contact', [ContactController::class, 'send'])
->name('concat.send');


Route::middleware(['UserMiddleware'])->group(function(){

// subjectprogram
Route::get('/addsubjects',[SubjectsProgramsController::class , 'index'])
->name('addsubjects.index');
Route::post('/addsubjects',[SubjectsProgramsController::class , 'store'])
->name('addsubjects.store');
Route::get('/subjects/edit/{id}',[SubjectsProgramsController::class , 'edit'])
    ->name('subjects.edit');
    Route::patch('/subjects/update/{id}', [SubjectsProgramsController::class, 'update'])
    ->name('subjects.update');
    Route::delete('subjects/delete/{id}', [SubjectsProgramsController::class, 'destroy'])->name('subjects.destroy');
/*
    //program
    Route::get('/addprogram',[ProgramController::class , 'index'])
->name('addprogram.index');
Route::post('/program/add',[ProgramController::class , 'store'])
->name('program.store');
Route::get('/program/edit/{id}',[ProgramController::class , 'edit'])
->name('program.edit');
Route::patch('/program/update/{id}', [ProgramController::class, 'update'])
->name('program.update');
Route::delete('program/delete/{id}', [ProgramController::class, 'destroy'])
->name('program.destroy');

*/
/*
    // subject
    Route::get('/addsubject',[AddsubjectController::class ,'index'])
    ->name('addsubject.index');

    Route::post('/subject/add',[AddsubjectController::class , 'store'])
    ->name('subject.store');

    Route::get('/subject/edit/{id}',[AddsubjectController::class , 'edit'])
    ->name('subject.edit');
    Route::patch('/subject/update/{id}', [AddsubjectController::class, 'update'])->name('subject.update');
    Route::delete('subject/delete/{id}', [AddsubjectController::class, 'destroy'])->name('subject.destroy');
*/
    //coordinators
    Route::get('/addcoordinators',[CoordinatorController::class , 'index'])
    ->name('addcoordinator.index');
    Route::post('/coordinator/add',[CoordinatorController::class , 'store'])
    ->name('coordinator.store');
    Route::get('/coordinator/edit/{id}',[CoordinatorController::class , 'edit'])
    ->name('coordinator.edit');
    Route::patch('/coordinator/update/{id}', [CoordinatorController::class, 'update'])->name('coordinator.update');
    Route::delete('coordinator/delete/{id}', [CoordinatorController::class, 'destroy'])->name('coordinator.destroy');

    // user
    Route::get('/user',[UserController::class , 'index'])
    ->name('user.index');
    Route::post('/user/add',[UserController::class , 'store'])
    ->name('adduser.store');
    Route::get('/user/edit/{id}',[UserController::class , 'edit'])
    ->name('user.edit');
    Route::patch('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

});
});
require __DIR__.'/auth.php';
