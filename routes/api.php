<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::apiResource('notes', NoteController::class);
Route::apiResource('categories', CategoryController::class);

Route::get('notes/stats/status', [NoteController::class, 'statsByStatus']);

Route::patch('notes/actions/archive-old-drafts', [NoteController::class, 'archiveOldDrafts']);

Route::get('users/{user}/notes', [NoteController::class, 'userNotesWithCategories']);

Route::get('notes-actions/search', [NoteController::class, 'search']);

Route::get('users/{user}/pinned-notes', [NoteController::class, 'getPinnedNotes']);

Route::patch('notes/{id}/publish', [NoteController::class, 'publishNote']);
Route::patch('notes/{id}/archive', [NoteController::class, 'archiveNote']);
Route::patch('notes/{id}/pin', [NoteController::class, 'pinNote']);
Route::patch('notes/{id}/unpin', [NoteController::class, 'unpinNote']);
