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

        \DB::beginTransaction();
        try {
            Comment::create([
                'comment' => $request->comment,
                'project_id' => $project->id,
                'task_id' => $task->id,
                'user_id' => $request->user()->id,
            ]);
            \DB::commit();
            $flash = ['success' => __('Comment created successfully.')];
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500, 'サーバーでエラーが発生しました。');
        }

        return redirect()
            ->route('tasks.edit', ['project' => $project->id, 'task' => $task])
            ->with($flash);
    }

    public function destroy(Project $project, Task $task, Comment $comment, Request $request)
    {
        if ($comment->user_id === $request->user()->id) {
            \DB::beginTransaction();
            try {
                $comment->delete();
                \DB::commit();
                $flash = ['success' => __('Comment deleted successfully.')];
            } catch (\Throwable $e) {
                \DB::rollback();
                abort(500, 'サーバーでエラーが発生しました。');
            }
        } else {
            abort(403, '削除する権限がありません');
        }
        return redirect()
            ->route('tasks.edit', ['project' => $project->id, 'task' => $task])
            ->with($flash);
    }
}
