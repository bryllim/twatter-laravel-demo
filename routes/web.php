<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwatController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use PDF;

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


// --- Admin Routes --- //
Route::get('/admin', function () {
    if(Auth::user()->type == 'admin'){
        return view('admin')
        ->with('users', App\Models\User::all())
        ->with('totaltwats', App\Models\Twat::count())
        ->with('totalreplies', App\Models\Reply::count());
    }else{
        return redirect()->route('login');
    }
})->name('admin');

Route::get('/users/{id}', function($id){
    $user = App\Models\User::find($id);
    return response()->json($user);
});

Route::post('/updateuser', function(Request $request){
    $user = App\Models\User::find($request->id);
    $user->name = $request->name;
    $user->email = $request->email;
    if($request->password != ""){
        $user->password = Hash::make($request->password);
    }
    $user->save();

    return redirect()->route('admin')->with('success', $user->name.' has been updated!');
})->name('updateuser');

Route::get('/deleteuser/{id}', function($id){
    if(Auth::user()->type == 'admin'){
        $user = App\Models\User::find($id);
        if($user->type == 'admin'){
            return redirect()->route('admin')->with('success', 'Selected user is an admin!');
        }else{
            $user->delete();
            return redirect()->route('admin')->with('success', 'User has been deleted!');
        }
    }else{
        return redirect()->route('login');
    }
})->name('deleteuser');

Route::get('/generate-pdf', function(){
    $users = App\Models\User::all();
    $data = [
        'users' => $users,
    ];
    $pdf = PDF::loadView('userlist', $data);
    
    return $pdf->stream('userlist.pdf');

})->name('generate-pdf');