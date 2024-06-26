<?php

use App\Http\Controllers\imageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
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

Route::get('/',[Controller::class, 'login'])->name('login');
Route::get('/register',[Controller::class, 'register'])->name('register');
Route::post('/register_submit',[UserController::class, 'register_submit'])->name('register_submit');
Route::post('/login_submit',[UserController::class , 'login_submit'])->name('login_submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',[UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/upload',[imageController::class, 'upload'])->name('upload');
    Route::post('/deteksi',[imageController::class, 'deteksi'])->name('deteksi');
    Route::get('/Result',[imageController::class, 'result'])->name('result');
    Route::get('/detail/{id}',[imageController::class, 'detail'])->name('detail');
    Route::get('/logout',[UserController::class, 'logout_submit'])->name('logout');
});
