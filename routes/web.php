<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublishedTaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\SignoutController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function(){
    Route::get('/sign-up', [SignupController::class, 'index'])->name('sign-up.index');
    Route::post('/sign-up', [SignupController::class, 'signUp'])->name('sign-up');

    Route::get('/sign-in', [SigninController::class, 'index'])->name('sign-in.index');
    Route::post('/sign-in', [SigninController::class, 'signIn'])->name('sign-in');
});

Route::middleware('auth')->group(function(){
    Route::post('/sign-out', [SignoutController::class, 'signOut'])->name('sign-out');

    Route::resource('tasks', TaskController::class);
    Route::get('tasks-table', [TaskController::class, 'table'])->name('tasks.table');

    Route::get('published-tasks', [PublishedTaskController::class, 'index'])->name('published-tasks.index');

    Route::get('published-tasks/{task}', [PublishedTaskController::class, 'view'])->name('published-tasks.view');

    Route::get('published-tasks-table', [PublishedTaskController::class, 'table'])->name('published-tasks.table');

    Route::patch('published-tasks/{task}', [PublishedTaskController::class, 'update'])->name('published-tasks.update');

    Route::get('profile/{user}', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
});
