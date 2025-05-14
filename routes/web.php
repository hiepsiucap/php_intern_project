<?php

use App\Http\Controllers\ScoreController;

Route::get('/scores/check', [ScoreController::class, 'check']);
Route::get('/scores/statistics', [ScoreController::class, 'levelStats']);
Route::get('/scores/top-group-a', [ScoreController::class, 'topGroupA']);
