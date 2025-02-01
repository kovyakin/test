<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.register');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/tasks', [\App\Http\Controllers\TaskModelController::class, 'index'])->name('tasks.index');
    Route::get('/tags', [\App\Http\Controllers\TagsModelController::class, 'index'])->name('tags.index');

});
