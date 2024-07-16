<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TuicalendarController;
use App\Http\Controllers\EventListController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/event-list', [EventListController::class, 'index'])->name('event.list');
Route::get('/event-list/', [EventListController::class, 'index'])->name('event.list');
Route::post('/event-list/date', [EventListController::class, 'search'])->name('event.list.search');
Route::post('/event-list/pdf', [EventListController::class, 'topdf'])->name('event.list.topdf');

Route::get('/event-create', [TuicalendarController::class, 'index'])->name('event.create');
Route::post('/event-create/save', [TuicalendarController::class, 'store'])->name('event.create.store');
Route::post('/event-create/update', [TuicalendarController::class, 'update'])->name('event.create.update');
Route::post('/event-create/destroy', [TuicalendarController::class, 'destroy'])->name('event.create.destroy');
