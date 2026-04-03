<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logoutall', [AuthController::class, 'logoutAll']);

        Route::prefix('change')->group(function () {
            Route::post('/password', [AuthController::class, 'changePassword']);
            Route::post('/firstname', [AuthController::class, 'changeFirstName']);
            Route::post('/lastname', [AuthController::class, 'changeLastName']);
        });

        Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
        Route::middleware('admin')->group(function () {
            Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        });
    });
});

Route::apiResource('notes', NoteController::class);
Route::apiResource('notes.tasks', TaskController::class)->scoped();

Route::get('notes/stats/status', [NoteController::class, 'statsByStatus']);

Route::patch('notes/actions/archive-old-drafts', [NoteController::class, 'archiveOldDrafts']);

Route::get('users/{user}/notes', [NoteController::class, 'userNotesWithCategories']);

Route::get('notes-actions/search', [NoteController::class, 'search']);

Route::get('users/{user}/pinned-notes', [NoteController::class, 'getPinnedNotes']);

Route::patch('notes/{id}/publish', [NoteController::class, 'publishNote']);
Route::patch('notes/{id}/archive', [NoteController::class, 'archiveNote']);
Route::patch('notes/{id}/pin', [NoteController::class, 'pinNote']);
Route::patch('notes/{id}/unpin', [NoteController::class, 'unpinNote']);
