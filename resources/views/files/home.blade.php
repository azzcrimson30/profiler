@extends('layouts.dashboard')

@section('title', 'Files')

@section('content')
<div class="page-header flex-between-wrap">
    <div>
        <h1>File Management</h1>
        <p>Manage file categories and uploaded files.</p>
    </div>
    <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <h2 class="card-section-title">Categories</h2>
    <div class="profiles-grid">
        @foreach($categories as $cat)
            <div class="profile-card card">
                <h3 class="profile-name">{{ $cat->name }}</h3>
                <p class="card-text">{{ $cat->description }}</p>
                <div class="d-flex gap-0.5">
                    <a href="{{ route('files.index', $cat->slug) }}" class="btn btn-primary">Open</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
