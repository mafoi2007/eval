<?php

use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [NoteController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:enseignant')->group(function () {
        Route::resource('classes', ClasseController::class);
        Route::resource('enseignants', EnseignantController::class)->parameters(['enseignants' => 'enseignant']);
        Route::resource('eleves', EleveController::class);
        Route::resource('evaluations', EvaluationController::class);
        Route::get('evaluations/{evaluation}/notes', [NoteController::class, 'index'])->name('notes.index');
        Route::put('notes/{note}', [NoteController::class, 'update'])->name('notes.update');
        Route::delete('notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    });

    Route::middleware('role:eleve')->group(function () {
        Route::get('mes-evaluations', [NoteController::class, 'mesEvaluations'])->name('eleve.evaluations');
        Route::get('composer/{evaluation}', [NoteController::class, 'create'])->name('eleve.composer');
        Route::post('composer/{evaluation}', [NoteController::class, 'store'])->name('eleve.composer.store');
        Route::get('mes-notes', [NoteController::class, 'show'])->name('eleve.notes');   
    });
});

require __DIR__.'/auth.php';