<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SavesController;
use App\Http\Controllers\CharactersController;

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

Route::post('/save/characters', CharactersController::class)
    ->name('save.characters');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
