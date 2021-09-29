<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UrlsController;

Route::get('/', [ MainController::class, 'home' ])->name('home');

Route::post('/urls/{id}/checks', [ UrlsController::class, 'checks' ])->name('check');

Route::resource('urls', UrlsController::class);
