<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UrlsController;

Route::get('/', [ MainController::class, 'home' ])->name('home');

// Route::get('/urls', [ MainController::class, 'urls' ])->name('urls');
// Route::get('/urls/{id}', [ MainController::class, 'urlShow' ])->name('urlShow');
Route::post('/urls/{id}/checks', [ MainController::class, 'checks' ])->name('check');

Route::resource('urls', UrlsController::class);
