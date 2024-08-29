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
    Route::post('/user/update',[UserController::class, 'update'])->name('update_user');
    Route::get('/dashboard',[UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/scan', [UserController::class, 'scan'])->name('scan');
    Route::post('/upload',[imageController::class, 'upload'])->name('upload');
    Route::post('/deteksi',[imageController::class, 'deteksi'])->name('deteksi');
    Route::get('/Result',[imageController::class, 'result'])->name('result');
    Route::get('/history',[Controller::class,'history'])->name('history');
    Route::get('/detail/{id}',[Controller::class, 'detail'])->name('detail');
    Route::get('/delete/{id}',[Controller::class,'destroy'])->name('hapus');
    Route::get('/logout',[UserController::class, 'logout_submit'])->name('logout');
});
