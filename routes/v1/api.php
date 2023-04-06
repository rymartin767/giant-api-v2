<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PilotController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FlashcardController;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('airlines', AirlineController::class)->name('api.airlines');
    Route::get('articles', ArticleController::class)->name('api.articles');
    Route::get('awards', AwardController::class)->name('api.awards');
    Route::get('employee', EmployeeController::class)->name('api.employee');
    Route::get('events', EventController::class)->name('api.events');
    Route::get('flashcards', FlashcardController::class)->name('api.airlines');
    Route::get('pilots', PilotController::class)->name('api.pilots');
});