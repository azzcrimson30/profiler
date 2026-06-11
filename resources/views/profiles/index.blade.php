@extends('layouts.dashboard')

@section('title', 'My Profiles')

@section('content')
<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1>My Profiles</h1>
        <p>Manage your resume profiles</p>
    </div>
    <a href="{{ route('profiles.create') }}" class="btn btn-primary">+ Create Profile</a>
</div>

@if($profiles->isEmpty())
    <div class="card" style="text-align:center;padding:3rem;">
        <div style="font-size:3rem;margin-bottom:1rem;">📋</div>
        <h3 style="margin-bottom:0.5rem;">No Profiles Yet</h3>
        <p style="color:var(--text-muted);margin-bottom:1.5rem;">Create your first profile to start building your resume.</p>
        <a href="{{ route('profiles.create') }}" class="btn btn-primary">Create Your First Profile</a>
    </div>
@else
    <div class="profiles-grid">
        @foreach($profiles as $profile)
            <div class="card profile-card">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;">
                    <div>
                        <h3 style="font-size:1.1rem;font-weight:600;">{{ $profile->first_name }} {{ $profile->last_name }}</h3>
                        @if($profile->title)
                            <p style="color:var(--text-muted);font-size:0.85rem;">{{ $profile->title }}</p>
                        @endif
                    </div>
                    <span class="badge badge-info">{{ $profile->created_at->format('M d, Y') }}</span>
                </div>

                @if($profile->summary)
                    <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $profile->summary }}</p>
                @endif

                @if($profile->skills && count($profile->skills) > 0)
                    <div style="display:flex;flex-wrap:wrap;gap:0.35rem;margin-bottom:1rem;">
                        @foreach(array_slice($profile->skills, 0, 5) as $skill)
                            <span style="padding:0.15rem 0.5rem;background:#eff6ff;color:#2563eb;border-radius:9999px;font-size:0.7rem;font-weight:500;">{{ $skill }}</span>
                        @endforeach
                        @if(count($profile->skills) > 5)
                            <span style="padding:0.15rem 0.5rem;background:#f1f5f9;color:var(--text-muted);border-radius:9999px;font-size:0.7rem;">+{{ count($profile->skills) - 5 }} more</span>
                        @endif
                    </div>
                @endif

                <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                    <a href="{{ route('profiles.show', $profile) }}" class="btn btn-secondary btn-sm">View</a>
                    <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <a href="{{ route('profiles.resume', $profile) }}" class="btn btn-primary btn-sm" target="_blank">Generate Resume</a>
                    <form method="POST" action="{{ route('profiles.destroy', $profile) }}" onsubmit="return confirm('Are you sure you want to delete this profile?');" style="display:inline;">
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