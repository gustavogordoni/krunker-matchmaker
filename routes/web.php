<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchmakerController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/matchmaker', [MatchmakerController::class, 'fetchGames']);
Route::get('/', [MatchmakerController::class, 'index']);
