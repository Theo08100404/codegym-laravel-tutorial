<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::resource('projects', ProjectController::class)
    ->middleware(['auth']);

Route::resource('projects/{project}/tasks', TaskController::class)
    ->middleware(['auth']);

Route::resource('projects/{project}/tasks/{task}/comments', App\Http\Controllers\CommentController::class)
    ->only(['store', 'destroy'])
    ->middleware(['auth']);

Route::resource('projects/{project}/tasks/{task}/images', App\Http\Controllers\ImageController::class)
    ->only(['store', 'destroy'])
    ->middleware(['auth']);

Route::resource('projects/{project}/tasks/create/files', App\Http\Controllers\FileController::class)
    ->only(['store', 'destroy'])
    ->middleware(['auth']);
