<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProjectController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $projects = \App\Models\Project::all();
    return view('guests.home', compact('projects'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('projects', ProjectController::class);
    });
});
