<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UrlsController;
use App\Http\Controllers\UrlCheckController;

Route::get('/', [MainController::class, 'home'])->name('home');
Route::resource('urls.checks', UrlCheckController::class)->only(['store']);
Route::resource('urls', UrlsController::class)->except([
    'create', 'edit', 'update', 'destroy'
]);
