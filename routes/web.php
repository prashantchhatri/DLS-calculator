<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/nrr-predictor');

Route::get('/dls', function () {
    return view('home', ['activeTab' => 'dls', 'title' => 'DLS Calculator']);
})->name('dls.calculator');

Route::get('/nrr', function () {
    return view('home', ['activeTab' => 'nrr', 'title' => 'NRR Calculator']);
})->name('nrr.calculator');

Route::get('/nrr-predictor', function () {
    return view('home', ['activeTab' => 'nrr-predictor', 'title' => 'NRR Predictor']);
})->name('nrr.predictor');
