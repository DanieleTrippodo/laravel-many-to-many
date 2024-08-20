@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Project</h1>
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Project Name:</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" id="description" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="type_id">Project Type:</label>
            <select class="form-control" name="type_id" id="type_id">
                <option value="">Select Type</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="technologies">Technologies:</label>
            <select class="form-control" name="technologies[]" id="technologies" multiple>
                @foreach ($technologies as $technology)
                    <option value="{{ $technology->id }}" {{ collect(old('technologies'))->contains($technology->id) ? 'selected' : '' }}>
                        {{ $technology->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image_file">Upload Image:</label>
            <input type="file" class="form-control" name="image_file" id="image_file">
        </div>

        <button type="submit" class="btn btn-primary">Create Project</button>
    </form>
</div>
@endsection
