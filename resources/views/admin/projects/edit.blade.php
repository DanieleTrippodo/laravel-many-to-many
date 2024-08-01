@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Project</h1>
    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Project Name:</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $project->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" id="description" required>{{ $project->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="technologies">Technologies:</label>
            <select multiple class="form-control" name="technologies[]">
                @foreach($technologies as $technology)
                    <option value="{{ $technology->id }}" {{ $project->technologies->contains($technology->id) ? 'selected' : '' }}>
                        {{ $technology->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image_file">Upload Image:</label>
            <input type="file" class="form-control" name="image_file" id="image_file">
            @if($project->image && !filter_var($project->image, FILTER_VALIDATE_URL))
                <div>
                    <img src="{{ asset('storage/' . $project->image) }}" alt="Project Image" style="max-width: 200px;">
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="image_url">Or Image URL:</label>
            <input type="url" class="form-control" name="image_url" id="image_url" value="{{ filter_var($project->image, FILTER_VALIDATE_URL) ? $project->image : '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Project</button>
    </form>
</div>
@endsection
