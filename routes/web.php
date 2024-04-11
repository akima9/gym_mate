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
});

Route::get('/boards/search', [BoardController::class, 'search'])->name('boards.search');
Route::resource('boards', BoardController::class);
Route::get('/chats/load', [ChatController::class, 'load'])->name('chats.load');
Route::post('/chats/send', [ChatController::class, 'send'])->name('chats.send');
Route::post('/chats/detail', [ChatController::class, 'detail'])->name('chats.detail');
Route::resource('chats', ChatController::class);

require __DIR__.'/auth.php';

/**
 * TO-DO
 * 1. 게시글 쓰기 페이지 내 운동일자, 운동시간 모바일에서 이상하게 나옴 기본값 설정 해주자!
 * 2. 회원가입 페이지 한글로 통일!
 * 3. 인증메일 메시지 변경!
 * 4. 모바일 채팅시 키보드 화면 스크롤 설정!
 */
