@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $project->name }}</h1>
    <p>{{ $project->description }}</p>
    <p><strong>Type:</strong> {{ $project->type ? $project->type->name : 'N/A' }}</p>
    <p><strong>Technologies:</strong></p>
    <ul>
        @foreach ($project->technologies as $technology)
            <li>{{ $technology->name }}</li>
        @endforeach
    </ul>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back to Projects</a>
</div>
@endsection
