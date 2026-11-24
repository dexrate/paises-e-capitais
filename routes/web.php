<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

// Route::view('/','home');

// Route::get('/mostra-dados', [MainController::class, 'mostraDados']);

Route::get('/', [MainController::class, 'iniciaJogo'])->name('start-game');
Route::post('/', [MainController::class, 'preparaJogo'])->name('prepara-game');

// loop do jogo
Route::get('/jogo', [MainController::class, 'jogo'])->name('jogo');

Route::get('/respostas/{resposta}', [MainController::class, 'resposta'])->name('resposta');
Route::get('/proxima-questao', [MainController::class, 'proximaQuestao'])->name('proxima');

// mostra resultados
Route::get('/resultado', [MainController::class, 'resultado'])->name('resultado');
