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
            'image_url' => 'nullable|url',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'type_id' => $request->type_id,
        ]);

        // Gestisci il caricamento dell'immagine dal file
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('projects', 'public');
            $project->image = $path;
        } elseif ($request->filled('image_url')) {
            // Gestisci il caricamento dell'immagine dall'URL
            $project->image = $request->image_url;
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
            'image_url' => 'nullable|url',
        ]);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'type_id' => $request->type_id,
        ]);

        // Gestisci il caricamento dell'immagine dal file
        if ($request->hasFile('image_file')) {
            if ($project->image && !filter_var($project->image, FILTER_VALIDATE_URL)) {
                Storage::delete('public/' . $project->image);
            }
            $path = $request->file('image_file')->store('projects', 'public');
            $project->image = $path;
        } elseif ($request->filled('image_url')) {
            // Gestisci il caricamento dell'immagine dall'URL
            if ($project->image && !filter_var($project->image, FILTER_VALIDATE_URL)) {
                Storage::delete('public/' . $project->image);
            }
            $project->image = $request->image_url;
        }

        $project->technologies()->sync($request->technologies);

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->image && !filter_var($project->image, FILTER_VALIDATE_URL)) {
            Storage::delete('public/' . $project->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Project deleted successfully.');
    }
}
