<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin'])->group(function () {

        Route::resource('classes', ClasseController::class);
        Route::resource('eleves', EleveController::class);
        Route::resource('evaluations', EvaluationController::class);

        Route::get('notes/{evaluation}', [NoteController::class, 'index']);
        Route::delete('notes/{note}', [NoteController::class, 'destroy']);

        Route::get('pdf/classe/{classe}', [AdminController::class, 'generatePdf']);
    });

    Route::middleware(['role:eleve'])->group(function () {

        Route::get('composer/{evaluation}', [NoteController::class, 'create']);
        Route::post('composer/{evaluation}', [NoteController::class, 'store']);

        Route::get('ma-note', [NoteController::class, 'show']);
    });

});

require __DIR__.'/auth.php';
