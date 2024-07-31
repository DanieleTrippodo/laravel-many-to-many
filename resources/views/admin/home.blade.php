@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Benvenuto nella schermata di back-office.</p>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Create Post</a>
</div>
@endsection
