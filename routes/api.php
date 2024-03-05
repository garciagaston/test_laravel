<?php

use App\Http\Controllers\EntityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/{category}', [EntityController::class, 'index'])->name('entities.index');
