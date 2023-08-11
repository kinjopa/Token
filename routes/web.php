<?php

use Illuminate\Support\Facades\Route;

// web
Route::get('/', '\App\Http\Controllers\MainController@Index');

// api
Route::prefix('api/v1')->group(function () {
    Route::get('/foo', '\App\Http\Api\v1\foo\FooController@handleRequest');
});
