<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('tasks', App\Http\Controllers\ApiControllers\ApiTasksController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->middlewareFor('index','ability:read')
        ->middlewareFor('store','ability:create')
        ->middlewareFor('update','ability:update')
        ->middlewareFor('destroy','ability:delete');

    Route::apiResource('tags', App\Http\Controllers\ApiControllers\ApiTagsController::class)
        ->middlewareFor('index','ability:read')
        ->middlewareFor('store','ability:create')
        ->middlewareFor('update','ability:update')
        ->middlewareFor('destroy','ability:delete')
        ->only(['index', 'store', 'update', 'destroy']);
});






