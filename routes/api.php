<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('tasks', App\Http\Controllers\ApiControllers\ApiTasksController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->middlewareFor('index','ability:read');

    Route::apiResource('tags', App\Http\Controllers\ApiControllers\ApiTagsController::class)
        ->only(['index', 'store', 'update', 'destroy']);
});





//Route::middleware('auth:sanctum')->group(function () {
//    Route::get('/tasks', [App\Http\Controllers\ApiControllers\ApiTasksController::class,'index'])
//        ->middleware('ability:read');
//
//
//});





