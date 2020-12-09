<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    Route::post('/auth', 'App\Http\Controllers\Auth\ApiAuthController@login');

    Route::post('/users', 'App\Http\Controllers\Auth\ApiAuthController@register');

    Route::middleware('auth:api')->group(function () {
        Route::get('/tasks', 'App\Http\Controllers\Api\V1\TaskController@index');
        Route::post('/tasks', 'App\Http\Controllers\Api\V1\TaskController@store');
        Route::post('/tasks/{id}/set-status/{status}', 'App\Http\Controllers\Api\V1\TaskController@setStatus');
    });
});
