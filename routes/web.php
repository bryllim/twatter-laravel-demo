<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwatController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReactionController;

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

// Reaction routes
Route::post('/reaction', [ReactionController::class, 'create'])->name('reaction.create');
Route::get('/reaction/{id}', [ReactionController::class, 'delete'])->name('reaction.delete');

// Reply routes
Route::post('/createreply', [ReplyController::class, 'create'])->name('createreply');
Route::get('/deletereply/{id}', [ReplyController::class, 'delete'])->name('deletereply');