<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortLinkController;

// Página principal
Route::get('/', [ShortLinkController::class, 'index'])->name('home');

// Criar um novo link encurtado
Route::post('/shorten', [ShortLinkController::class, 'store'])->name('shorten.store');

// Redirecionar para a URL original
Route::get('/{shortCode}', [ShortLinkController::class, 'redirect'])->name('shorten.redirect');

// Excluir um link encurtado
Route::delete('/shorten/{id}', [ShortLinkController::class, 'destroy'])->name('shorten.destroy');
