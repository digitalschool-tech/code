<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LevelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SandboxController;
use App\Http\Controllers\PageController;
use App\Models\course;
use Illuminate\Support\Facades\Auth;

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




Route::post('/sandbox/runCode', [SandboxController::class, 'runCode'])->name('run.code');
Route::resource('/sandbox', SandboxController::class);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/kursi/{course_id}/mesimi/{lesson_id}/niveli/{level_id}', [LevelController::class, 'show']);
Route::get('/kursi/{id}', [CourseController::class, 'index']);
Route::get('/{path?}', [PageController::class, 'index']);
