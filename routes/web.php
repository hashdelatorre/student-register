<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

// Only for guests (logged-in users get sent to /students)
Route::middleware(['guest', 'no.cache'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('/register', [AuthController::class, 'register'])->middleware('once')->name('register.store');
});

// Only for logged-in users
Route::middleware(['auth', 'no.cache'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::redirect('/', '/students');

    Route::resource('departments', DepartmentController::class)->only(['index', 'store'])->middleware('once');
    Route::resource('subjects', SubjectController::class)->only(['index', 'store'])->middleware('once');
    Route::resource('students', StudentController::class)->only(['index', 'store'])->middleware('once');
    Route::resource('enrollments', EnrollmentController::class)->only(['index', 'store'])->middleware('once');
});