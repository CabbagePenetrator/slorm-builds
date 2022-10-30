<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SavesController;
use App\Http\Controllers\CharactersController;
use App\Http\Controllers\BuildController;

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

Route::get('/', [SavesController::class, 'create'])
    ->name('saves.create');

Route::post('/save', [SavesController::class, 'store'])
    ->name('saves.store');

Route::get('/save/{save}', [SavesController::class, 'show'])
    ->name('saves.show');

Route::post('/characters', CharactersController::class)
    ->name('characters');

/** Builds */
Route::get('/builds', [BuildController::class, 'index'])
    ->name('builds');

Route::get('/builds/create', [BuildController::class, 'create'])
    ->name('builds.create');

Route::post('/builds', [BuildController::class, 'store'])
    ->name('builds.store');

Route::get('/builds/{build:slug}', [BuildController::class, 'show'])
    ->name('builds.show');

Route::get('/builds/{build:slug}/edit', [BuildController::class, 'edit'])
    ->name('builds.edit');

Route::put('/builds/{build}', [BuildController::class, 'update'])
    ->name('builds.update');

Route::delete('/builds/{build}', [BuildController::class, 'destroy'])
    ->name('builds.destroy');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
