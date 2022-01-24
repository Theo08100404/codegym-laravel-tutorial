<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function store(Request $request, Project $project, Task $task)
    {

        $request->validate([
            'file_img' => 'max:10240|mimes:jpg,png,gif'
        ]);

        $task_id = $task->id;
        $count = Image::where('task_id', '=', $task_id)->count();


        if ($count <= 4) {
            $fileName = $request->file_img->getClientOriginalName();
            $path = $request->file_img->storeAs('', $fileName, 'public');
            Image::create([
                'image' => $path,
                'project_id' => $project->id,
                'task_id' => $task->id,
            ]);
        } else {
            $flash = ['error' => __('You can upload up to 5 files.')];
        }

        if (empty($flash)) {
            return redirect()
                ->route('tasks.edit', ['project' => $project->id, 'task' => $task]);
        } else {
            return redirect()
                ->route('tasks.edit', ['project' => $project->id, 'task' => $task])
                ->with($flash);
        }
    }

    public function destroy(Project $project, Task $task, Image $image)
    {
        $deleteFilePath = $image->image;
        Storage::delete('public/' . $deleteFilePath);
        if ($image->delete()) {
            $flash = ['success' => __('Image deleted successfully.')];
        } else {
            $flash = ['error' => __('Failed to delete the Image.')];
        }

        return redirect()
            ->route('tasks.edit', ['project' => $project->id, 'task' => $task])
            ->with($flash);
    }
}
