<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MediaObjectController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request; // Import the Request class
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::name('auth.')->prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/sign-in', 'signInRequest')->middleware('guest');
    Route::post("/sign-up", 'signUpRequest')->middleware('guest');
    Route::post('/sign-out', 'signOutRequest')->middleware('auth');
    Route::post('/refresh-token', 'refreshTokenRequest')->middleware('auth:api');
});

Route::name('user.')->prefix('user')->controller(UserController::class)->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', 'me');
        Route::patch('/update', 'updateUserRequest');
        Route::patch('/update-meta', 'updateUserMeta');
        Route::post('/deactivate', 'deactivateAccountRequest');
        Route::post('/delete', 'deleteAccountRequest');
        Route::post('/{user:username}/follow', 'followUser');
        Route::post('/{user:username}/unfollow', 'unfollowUser');
    });
    Route::get('/{user:username}', 'getUserByUsername');
    Route::get('/{user:username}/followers', 'getUserFollowers');
    Route::get('/{user:username}/following', 'getUserFollowing');
});

Route::middleware('auth:api')->name('message.')->prefix('message')->controller(MessageController::class)->group(function () {
    Route::get('/', 'getMessages');
    Route::post('/send', 'sendMessage');
    Route::post('/{message}/delete', 'deleteMessage');
});
