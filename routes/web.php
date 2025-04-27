<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\labelController;

Route::get('/', function () {
    return view('main');
})->name('main');



//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/tasks', function () {
    return view('tasks');
});

Route::get('/task_statuses', [TaskStatusController::class, 'index'])->name('task_status.index');
Route::get('/task_statuses/create', [TaskStatusController::class, 'create'])->name('task_status.create');
Route::post('/task_statuses', [TaskStatusController::class, 'store'])->name('task_status.store');
Route::get('/task_statuses/{id}/edit', [TaskStatusController::class, 'edit'])->name('task_status.edit');
Route::patch('/task_statuses/{id}', [TaskStatusController::class, 'update'])->name('task_status.update');
Route::delete('/task_statuses/{id}', [TaskStatusController::class, 'destroy'])->name('task_status.delete');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasksphp.show');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.delete');

Route::get('/labels', [labelController::class, 'index'])->name('labels.index');
Route::get('/labels/create', [labelController::class, 'create'])->name('labels.create');
Route::post('/labels', [labelController::class, 'store'])->name('labels.store');
Route::get('/labels/{id}/edit', [labelController::class, 'edit'])->name('labels.edit');
Route::patch('/labels/{id}', [labelController::class, 'update'])->name('labels.update');
Route::delete('/labels/{id}', [labelController::class, 'destroy'])->name('labels.delete');

