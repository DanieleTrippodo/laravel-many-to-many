<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('user', 'type', 'technologies')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'array|exists:technologies,id',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'type_id' => $request->type_id,
        ]);

        // Gestione dell'immagine caricata dal file
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('projects', 'public');
            $project->image = $path;
        }

        $project->technologies()->sync($request->technologies);

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'array|exists:technologies,id',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'type_id' => $request->type_id,
        ]);

        // Gestione dell'immagine caricata dal file
        if ($request->hasFile('image_file')) {
            if ($project->image) {
                Storage::delete('public/' . $project->image);
            }
            $path = $request->file('image_file')->store('projects', 'public');
            $project->image = $path;
        }

        $project->technologies()->sync($request->technologies);

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::delete('public/' . $project->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Project deleted successfully.');
    }
}
