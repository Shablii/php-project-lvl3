<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UrlsController;

//Route::get('/', 'MainController@home');
//Route::get('/', function () {
//    $test = new MainController();
//    return view('home');
//});

Route::get('/', [ MainController::class, 'home' ])->name('home');
// Route::get('/urls', [ MainController::class, 'urls' ])->name('urls');
// Route::get('/urls/{id}', [ MainController::class, 'urlShow' ])->name('urlShow');
// Route::post('/urls', [ MainController::class, 'urlsAdd' ]);

Route::resource('urls', UrlsController::class);
