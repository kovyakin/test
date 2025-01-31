<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('tasks', App\Http\Controllers\ApiControllers\ApiTasksController::class)
    ->middleware('auth:sanctum');

Route::apiResource('tags', App\Http\Controllers\ApiControllers\ApiTagsController::class)
    ->middleware('auth:sanctum');
