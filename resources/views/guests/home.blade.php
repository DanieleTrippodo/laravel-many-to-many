@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Guest Home</h1>
    <p>Benvenuto nel sito.</p>
    @auth
        <!-- Bottone visibile solo per l'amministratore -->
        @if (Auth::user()->is_admin)
            <a href="{{ route('admin.home') }}" class="btn btn-primary">Vai alla Admin Dashboard</a>
        @endif
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Crea Post</a>
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
                        @if ($project->technologies->count() > 0)
                            <p><strong>Technologies:</strong>
                                <ul>
                                    @foreach ($project->technologies as $technology)
                                        <li>{{ $technology->name }}</li>
                                    @endforeach
                                </ul>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
