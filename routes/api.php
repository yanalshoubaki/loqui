<?php

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

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->name('auth.')->middleware('guest')->controller(AuthController::class)->group(function () {
    Route::post('/sign-in', 'signIn')->name('sign-in');
    Route::post('/sign-up', 'signUp')->name('sign-up');
});

Route::prefix('/media')->name('media.')->middleware('auth:api')->controller(MediaObjectController::class)->group(function () {
    Route::post('/create-media', 'createMedia')->name('create-media');
});

Route::prefix('/user')->name('user.')->middleware('auth:api')->controller(UserController::class)->group(function () {
    Route::get('/profile', 'getMyProfile');
    Route::get('/profile/followers', 'getMyFollowers');
    Route::get('/profile/followings', 'getMyFollowings');
    Route::prefix('/following')->name('following.')->controller(UserController::class)->group(function () {
        Route::get('/list', 'getFollowingList');
        Route::post('/add', 'addUserToFollowingList');
        Route::post('/remove', 'removeUserFromFollowingList');
    });
    Route::prefix('/followers')->name('followers.')->controller(UserController::class)->group(function () {
        Route::get('/list', 'getFollowersList');
        Route::post('/add', 'addUserToFollowersList');
        Route::post('/remove', 'removeUserFromFollowersList');
    });

});
