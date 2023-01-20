<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwatController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profile/{id}', [HomeController::class, 'profile'])->name('profile');

// Twat routes
Route::post('/createtwat', [TwatController::class, 'create'])->name('createtwat');
Route::get('/deletetwat/{id}', [TwatController::class, 'delete'])->name('deletetwat');