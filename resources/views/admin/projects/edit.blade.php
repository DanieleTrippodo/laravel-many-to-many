@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Project</h1>
    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Project Name:</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $project->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" id="description" required>{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="type_id">Project Type:</label>
            <select class="form-control" name="type_id" id="type_id">
                <option value="">Select Type</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ old('type_id', $project->type_id) == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="technologies">Technologies:</label>
            <select class="form-control" name="technologies[]" id="technologies" multiple>
                @foreach ($technologies as $technology)
                    <option value="{{ $technology->id }}" {{ $project->technologies->contains($technology->id) ? 'selected' : '' }}>
                        {{ $technology->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image_file">Upload Image:</label>
            <input type="file" class="form-control" name="image_file" id="image_file">
            @if($project->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $project->image) }}" alt="Project Image" style="max-width: 200px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Project</button>
    </form>
</div>
@endsection
