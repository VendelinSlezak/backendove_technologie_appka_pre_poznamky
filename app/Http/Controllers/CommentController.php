<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function showNoteComments(Request $request, Note $note) {
        $this->authorize('viewAny', Comment::class);
        $comments = $note->comments()->with('user')->get();
        return response()->json(['comments' => $comments], Response::HTTP_OK);
    }

    public function showTaskComments(Request $request, Task $task) {
        $this->authorize('viewAny', Comment::class);
        $comments = $task->comments()->with('user')->get();
        return response()->json(['comments' => $comments], Response::HTTP_OK);
    }

    public function addCommentToNote(Request $request, Note $note) {
        $this->authorize('createInNote', [Comment::class, $note]);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:4096'],
        ]);

        $note->comments()->create([
            'body' => $validated['body'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['message' => 'Komentár na poznámke bol úspešne vytvorený.'], Response::HTTP_OK);
    }

    public function addCommentToTask(Request $request, Task $task) {
        $this->authorize('createInTask', [Comment::class, $task]);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:4096'],
        ]);

        $task->comments()->create([
            'body' => $validated['body'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['message' => 'Komentár na úlohe bol úspešne vytvorený.'], Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', [Comment::class, $comment]);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:4096'],
        ]);

        $comment->update([
            'body' => $validated['body'],
        ]);

        return response()->json(['message' => 'Komentár bol úspešne aktualizovaný.'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', Comment::class);

        $comment->delete();

        return response()->json(['message' => 'Komentár bol úspešne vymazaný.'], Response::HTTP_OK);
    }
}
