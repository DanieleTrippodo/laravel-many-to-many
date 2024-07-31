@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Guest Home</h1>
    <p>Benvenuto nel sito normale.</p>
    @auth
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Create Post</a>
    @endauth
    <div class="row">
        @foreach ($projects as $project)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->name }}</h5>
                        <p class="card-text">{{ $project->description }}</p>
                        @if ($project->type)
                            <p><strong>Type:</strong> {{ $project->type->name }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
