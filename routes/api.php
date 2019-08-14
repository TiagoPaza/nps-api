<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function () {
    Route::prefix((function () {
        $locale = request()->segment(3);
        return LaravelLocalization::setLocale($locale);
    })())->group(function () {
        Route::post('login', 'AuthController@login');

        Route::group(['middleware' => 'auth.jwt'], function () {
            Route::get('logout', 'AuthController@logout');
            Route::get('user', 'UserController@authenticated');

            Route::resource('users', 'UserController');
        });
    });
});
