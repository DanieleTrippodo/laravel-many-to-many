@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Post</h1>
    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Title</label>
            <input type="text" name="name" class="form-control" value="{{ $project->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Content</label>
            <textarea name="description" class="form-control" required>{{ $project->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="type_id">Type</label>
            <select name="type_id" class="form-control">
                <option value="">Select Type</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" @if($project->type_id == $type->id) selected @endif>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
