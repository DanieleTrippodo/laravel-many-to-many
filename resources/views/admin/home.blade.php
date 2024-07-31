@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Benvenuto nella admin dashboard.</p>

    <!-- Bottone per gestire i progetti -->
    <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">Modifica Post</a>
</div>
@endsection
