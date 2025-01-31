<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

//Route::resource('/tasks', ApiTagsController::class);
Route::apiResource('tags', app\Http\Controllers\ApiControllers\ApiTagsController::class)
    ->middleware('auth:sanctum');
//Route::get('/tasks', function () {
//    dd(1);
//});