<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SandboxController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Homepage (public)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact form (public)
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Guest only routes
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Registration routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Password reset routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Auth actions
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // User pages
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('/support', [HomeController::class, 'support'])->name('support');
    
    // Course routes
    Route::get('/courses', [HomeController::class, 'courses'])->name('courses');
    Route::get('/course/{id}', [HomeController::class, 'showCourse'])->name('course.show');
    
    // Level routes (changed from Albanian to English naming)
    Route::get('/course/{course_id}/lesson/{lesson_id}/level/{level_id}', [HomeController::class, 'showLevel'])
         ->name('level.show');
    
    Route::post('/course/{course_id}/lesson/{lesson_id}/level/{level_id}/complete', [HomeController::class, 'completeLevel'])
         ->name('level.complete');
         
    Route::post('/course/{course_id}/lesson/{lesson_id}/level/{level_id}/attempt', [HomeController::class, 'recordAttempt'])
         ->name('level.attempt');
});
