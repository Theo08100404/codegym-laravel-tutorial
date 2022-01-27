<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'keyword' => 'max:255',
        ]);

        $keyword = $request->input('keyword');
        $projects = Project::select('*');
        if ($request->has('keyword') && $keyword != '') {
            $projects = $projects
                ->where('key', 'like', '%' . $keyword . '%')
                ->orwhere('name', 'like', '%' . $keyword . '%');
        }
        $projects = $projects
            ->sortable('name')
            ->paginate(20)
            ->appends(['keyword' => $keyword]);

        return view('projects.index', compact('projects'), [
            'keyword' => $keyword,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|regex:/^[a-zA-Z0-9-_]+$/i|unique:projects,key,NULL,id,exist,1',
            'name' => 'required|string|max:255',
        ]);

        \DB::beginTransaction();
        try {
            Project::create([
                'key' => $request->key,
                'name' => $request->name,
                'created_user_id' => $request->user()->id,
            ]);
            \DB::commit();
            $flash = ['success' => __('Project created successfully.')];
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500, 'サーバーでエラーが発生しました。');
        }

        return redirect()->route('projects.index')
            ->with($flash);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'key' => "required|string|max:255|regex:/^[a-zA-Z0-9-_]+$/i|unique:projects,key,$project->id,id,exist,1",
            'name' => 'required|string|max:255',
        ]);

        \DB::beginTransaction();
        try {
            $project->update($request->all());
            \DB::commit();
            $flash = ['success' => __('Project updated successfully.')];
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500, 'サーバーでエラーが発生しました。');
        }

        return redirect()
            ->route('projects.edit', $project)
            ->with($flash);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        \DB::beginTransaction();
        try {
            $project->delete();
            \DB::commit();
            $flash = ['success' => __('Project deleted successfully.')];
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500, 'サーバーでエラーが発生しました。');
        }

        return redirect()
            ->route('projects.index')
            ->with($flash);
    }
}
