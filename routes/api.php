<?php

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

Route::prefix('v1')->group(function () {
    Route::prefix((function () {
        $locale = request()->segment(3);
        return LaravelLocalization::setLocale($locale);
    })())->group(function () {
        /** example.com || example.com/en */
        Route::post('login', 'AuthController@login');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::get('logout', 'AuthController@logout');
            Route::get('user', 'UserController@authenticated');

            Route::resource('users', 'UserController');
            Route::resource('plans', 'PlanController');
            Route::resource('questions', 'QuestionController');
            Route::resource('plans-activities', 'PlanActivityController', [
                'parameters' => ['plans-activities' => 'planActivity']
            ]);
            Route::resource('questions-replies', 'QuestionReplyController', [
                'parameters' => ['questions-replies' => 'questionReply']
            ]);
        });
    });
});
