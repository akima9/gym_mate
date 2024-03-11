<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('boards.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/gym', [ProfileController::class, 'updateForGym'])->name('profile.updateForGym');

    Route::post('/gyms/find', [GymController::class, 'find'])->name('gyms.find');
    Route::post('/gyms/store', [GymController::class, 'store'])->name('gyms.store');
});

Route::resource('boards', BoardController::class);
Route::get('/chats/load', [ChatController::class, 'load'])->name('chats.load');
Route::post('/chats/send', [ChatController::class, 'send'])->name('chats.send');
Route::post('/chats/detail', [ChatController::class, 'detail'])->name('chats.detail');
Route::resource('chats', ChatController::class);

require __DIR__.'/auth.php';
