<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskStatusController;

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

require __DIR__.'/auth.php';

Route::get('/tasks', function () {
    return view('tasks');
});

Route::get('/task_statuses', [TaskStatusController::class, 'index'])->name('task_status.index');
Route::get('/task_statuses/create', [TaskStatusController::class, 'create'])->name('task_status.create');
Route::post('/task_statuses', [TaskStatusController::class, 'store'])->name('task_status.store');
Route::get('/task_statuses/{id}/edit', [TaskStatusController::class, 'edit'])->name('task_status.edit');
Route::patch('/task_statuses/{id}', [TaskStatusController::class, 'update'])->name('task_status.update');
Route::delete('/task_statuses/{id}', [TaskStatusController::class, 'destroy'])->name('task_status.delete');



Route::get('/labels', function () {
    return view('labels');
});
