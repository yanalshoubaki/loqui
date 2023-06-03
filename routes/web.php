<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaObjectController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFollowController;
use App\Models\UserFollow;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/messages/inbox', [MessageController::class, 'inbox'])->name("messages.inbox");
    Route::post('/messages/add-replay', [MessageController::class, 'addReplay'])->name("messages.add-replay");
    Route::resource('messages', App\Http\Controllers\MessageController::class);
    Route::resource('mediaObjects', App\Http\Controllers\MediaObjectController::class);
    Route::resource('user', UserController::class)->scoped([
        'user' => 'username'
    ]);
    Route::resource('user.messages', MessageController::class)->only([
        'index', 'show'
    ]);
    Route::resource('user.follows', UserFollowController::class)->only([
        'index', 'show'
    ]);
});


require __DIR__ . '/auth.php';
