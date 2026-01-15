<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\gerelesroute;

Route::get('/', function () {
    return view('home.index');
});

Route::get('/animale', [gerelesroute::class, 'animale'])
    ->name('animale');
Route::get('/fruits', [gerelesroute::class, 'fruits'])
    ->name('fruits');
Route::get('/color', [gerelesroute::class, 'color'])
    ->name('color');
Route::get('/hopetal', [gerelesroute::class, 'hopetal'])
    ->name('hopetal');
Route::get('/love', [gerelesroute::class, 'love'])
    ->name('love');
Route::get('/math', [gerelesroute::class, 'math'])
    ->name('math');
Route::get('/transport', [gerelesroute::class, 'transport'])
    ->name('transport');
Route::get('/francais', [gerelesroute::class, 'francais'])
    ->name('francais');
Route::get('/anglais', [gerelesroute::class, 'anglais'])
    ->name('anglais');
Route::get('/shopping', [gerelesroute::class, 'shopping'])
    ->name('shopping');
Route::get('/café', [gerelesroute::class, 'café'])
    ->name('café');
