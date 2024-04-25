<?php

use Illuminate\Support\Facades\Route;

Route::get('/table/get', [\Kovyakin\Test\app\Http\Controllers\TableController::class,'get']);
