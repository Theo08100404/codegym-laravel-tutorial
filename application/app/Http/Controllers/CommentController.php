<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Project $project, Task $task)
    {
        $request->validate([
            'comment' => 'min:1|max:1000'
        ]);

        if (Comment::create([
            'comment' => $request->comment,
            'project_id' => $project->id,
            'task_id' =>$task->id,
            'user_id' => $request->user()->id,
        ])) {
            $flash = ['success' => __('Comment created successfully.')];
        } else {
            $flash = ['error' => __('Failed to create the comment.')];
        }

        return redirect()
            ->route('tasks.edit', ['project' => $project->id, 'task' => $task])
            ->with($flash);
    }

    public function destroy (Project $project, Task $task, Comment $comment ,Request $request)  
    {   
    
        if ($comment->user_id === $request->user()->id)  {
            $comment->delete();
            $flash = ['success' => __('Comment deleted successfully.')];
        } else {
            $flash = ['error' => __('Failed to delete the comment.')];
        }

        return redirect()
            ->route('tasks.edit', ['project' => $project->id , 'task' => $task])
            ->with($flash);
    }
}
