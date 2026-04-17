<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::middleware('auth:sanctum')->group(callback: function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logoutall', [AuthController::class, 'logoutAll']);

        Route::middleware('premium')->group(function () {
            Route::post('/notes/{note}/attachments', [AttachmentController::class, 'store']);
        });
        Route::get('/notes/{note}/attachments', [AttachmentController::class, 'index']);
        Route::get('attachments/notes/{attachment}', [AttachmentController::class, 'link']);
        Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy']);

        Route::post('/profile-photo', [AuthController::class, 'storeProfilePhoto']);
        Route::delete('/profile-photo', [AuthController::class, 'destroyProfilePhoto']);

        Route::prefix('change')->group(function () {
            Route::post('/password', [AuthController::class, 'changePassword']);
            Route::post('/firstname', [AuthController::class, 'changeFirstName']);
            Route::post('/lastname', [AuthController::class, 'changeLastName']);
        });

        Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
        Route::middleware('admin')->group(function () {
            Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
            Route::patch('notes/actions/archive-old-drafts', [NoteController::class, 'archiveOldDrafts']);
        });

        Route::patch('notes/{id}/publish', [NoteController::class, 'publishNote']);
        Route::patch('notes/{id}/archive', [NoteController::class, 'archiveNote']);
        Route::patch('notes/{id}/pin', [NoteController::class, 'pinNote']);
        Route::patch('notes/{id}/unpin', [NoteController::class, 'unpinNote']);
        Route::get('notes/stats/status', [NoteController::class, 'statsByStatus']);
        Route::get('notes-actions/search', [NoteController::class, 'search']);

        // notes
        Route::get('notes', [NoteController::class, 'index']);      // nástenka - všetky poznámky
        Route::get('/my-notes', [NoteController::class, 'myNotes']); // len moje poznámky (aj drafty)
        Route::post('/notes', [NoteController::class, 'store']);
        Route::get('/notes/{note}', [NoteController::class, 'show']);
        Route::patch('/notes/{note}', [NoteController::class, 'update']);
        Route::delete('/notes/{note}', [NoteController::class, 'destroy']);

        Route::apiResource('notes.tasks', TaskController::class)->scoped();

        Route::get('/notes/{note}/comments', [CommentController::class, 'showNoteComments']);
        Route::post('/notes/{note}/comments/{comment}', [CommentController::class, 'addCommentToNote']);
        Route::get('/tasks/{task}/comments', [CommentController::class, 'showTaskComments']);
        Route::post('/tasks/{task}/comments/{comment}', [CommentController::class, 'addCommentToTask']);
        Route::patch('/comments/{comment}', [CommentController::class, 'update']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    });
});

Route::get('users/{user}/notes', [NoteController::class, 'userNotesWithCategories']);
Route::get('users/{user}/pinned-notes', [NoteController::class, 'getPinnedNotes']);
