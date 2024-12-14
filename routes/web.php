<?php

use App\Http\Controllers\MemoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MemoryController::class, 'welcome']);
Route::post('/allocate', [MemoryController::class, 'allocate'])->name('welcome.allocate');
Route::post('/release/{id}', [MemoryController::class, 'release'])->name('welcome.release');
