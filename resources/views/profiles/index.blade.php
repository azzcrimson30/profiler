@extends('layouts.dashboard')

@section('title', 'My Profiles')

@section('content')
<div class="page-header flex-between-wrap">
    <div>
        <h1>My Profiles</h1>
        <p>Manage your resume profiles</p>
    </div>
    <a href="{{ route('profiles.create') }}" class="btn btn-primary">+ Create Profile</a>
</div>

@if($profiles->isEmpty())
    <div class="card card--centered">
        <div class="profile-icon">📋</div>
        <h3 class="mb-0-5">No Profiles Yet</h3>
        <p class="card-text mb-1-5">Create your first profile to start building your resume.</p>
        <a href="{{ route('profiles.create') }}" class="btn btn-primary">Create Your First Profile</a>
    </div>
@else
    <div class="profiles-grid">
        @foreach($profiles as $profile)
            <div class="card profile-card">
                <div class="profile-header">
                    <div>
                        <h3 class="profile-name">{{ $profile->first_name }} {{ $profile->last_name }}</h3>
                        @if($profile->title)
                            <p class="profile-title">{{ $profile->title }}</p>
                        @endif
                    </div>
                    <span class="badge badge-info">{{ $profile->created_at->format('M d, Y') }}</span>
                </div>

                    @if($profile->summary)
                    <p class="summary-clamp">{{ $profile->summary }}</p>
                @endif

                @if($profile->skills && count($profile->skills) > 0)
                    <div class="skills-wrap mb-1">
                        @foreach(array_slice($profile->skills, 0, 5) as $skill)
                            <span class="skill-pill">{{ $skill }}</span>
                        @endforeach
                        @if(count($profile->skills) > 5)
                            <span class="skill-pill-muted">+{{ count($profile->skills) - 5 }} more</span>
                        @endif
                    </div>
                @endif

                <div class="d-flex gap-0.5 flex-wrap">
                    <a href="{{ route('profiles.show', $profile) }}" class="btn btn-secondary btn-sm">View</a>
                    <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <a href="{{ route('profiles.resume', $profile) }}" class="btn btn-primary btn-sm" target="_blank">Generate Resume</a>
                    <form method="POST" action="{{ route('profiles.destroy', $profile) }}" onsubmit="return confirm('Are you sure you want to delete this profile?');" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif

<style>
    .profiles-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.25rem; }
    .profile-card { transition: transform 0.2s, box-shadow 0.2s; }
    .profile-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
</style>
@endsection