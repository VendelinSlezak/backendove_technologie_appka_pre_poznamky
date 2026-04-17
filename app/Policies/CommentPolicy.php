<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function createInNote(User $user, Note $note): bool
    {
        return true;
    }

    public function createInTask(User $user, Task $task): bool
    {
        return true;
    }

    public function update(User $user, Comment $comment): bool
    {
        return $comment->user_id === $user->id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $comment->user_id === $user->id;
    }
}
