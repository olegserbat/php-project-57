<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {
        $userID = auth()->user()->id;
        $data = $request->validated();
        $taskId = $data['task_id'];
        $data['user_id'] = $userID;
        $comment = new Comment();
        $comment->fill($data);
        $comment->save();
        return redirect("/tasks/$taskId");
    }

    public function edit($id)
    {
        $comment = Comment::find($id);
        $task = $comment->task;
        return view('comments.comment_edit', ['task' => $task, 'comment' => $comment]);
    }

    public function update(StoreCommentRequest $request, $id)
    {
        $comment = Comment::find($id);
        $user = auth()->user();
        $data = $request->validated();
        $taskId = $data['task_id'];
        $data['user_id'] = $user->id;
        $comment->fill($data);
        if($comment->creator->id == $user->id) {
            $comment->save();
        }
        return redirect("/tasks/$taskId");
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $taskId = $comment->task_id;
        $user = Auth::user();
        $taskOwner = User::find($comment->task->created_by_id);
        if($comment->creator->id == $user->id or $comment->creator->id == $taskOwner->id) {
            $comment->delete();
        }
        return redirect("/tasks/$taskId");
    }
}
