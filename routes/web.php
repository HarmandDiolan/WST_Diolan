<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

function set_active($route){
    if(is_array($route)){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tables', function () {
    return view('tables');
})->name('tables');

Route::get('/charts', function(){
    return view('charts');
})->name('charts');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Use Route::resource() for StudentController
Route::resource('student', StudentController::class)->middleware(['auth']);
Route::resource('subject', SubjectController::class)->middleware(['auth']);
Route::resource('enrollments', EnrollmentController::class)->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';