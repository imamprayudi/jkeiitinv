<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/test', function () {
//     return 'Testing route works!';
// });

