<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssdtServiceController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/services/fetch', [AssdtServiceController::class, 'fetchData']);
Route::get('/home', [UserController::class, 'index']);
Route::get('/service-consumption', function () {
    return view('service');
});
