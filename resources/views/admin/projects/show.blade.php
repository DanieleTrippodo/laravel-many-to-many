@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $project->name }}</h1>

    @if($project->image)
        <img src="{{ asset('storage/' . $project->image) }}"
             alt="Project Image"
             style="width: 300px; height: auto;">
    @else
        <p>No Image Available</p>
    @endif

    <p>{{ $project->description }}</p>

    <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>
@endsection
