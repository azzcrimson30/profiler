@extends('layouts.dashboard')

@section('title', $profile->first_name . ' ' . $profile->last_name . ' - Profile')

@section('content')
<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1>{{ $profile->first_name }} {{ $profile->last_name }}</h1>
        @if($profile->title)<p>{{ $profile->title }}</p>@endif
    </div>
    <div style="display:flex;gap:0.5rem;">
        <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('profiles.resume', $profile) }}" class="btn btn-primary" target="_blank">Generate Resume</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;">
    <div>
        @if($profile->summary)
        <div class="card">
            <h2 style="font-size:1rem;font-weight:600;margin-bottom:0.75rem;">Professional Summary</h2>
            <p style="color:var(--text-muted);font-size:0.9rem;line-height:1.7;">{{ $profile->summary }}</p>
        </div>
        @endif

        @if($profile->work_experiences && count($profile->work_experiences) > 0)
        <div class="card">
            <h2 style="font-size:1rem;font-weight:600;margin-bottom:1rem;">Work Experience</h2>
            @foreach($profile->work_experiences as $exp)
                <div style="margin-bottom:1.25rem;@if(!$loop->last)padding-bottom:1.25rem;border-bottom:1px solid var(--border);@endif">
                    <h3 style="font-size:0.95rem;font-weight:600;">{{ $exp['position'] ?? 'Position' }}</h3>
                    <p style="font-size:0.85rem;color:var(--primary);">{{ $exp['company'] ?? '' }}</p>
                    <p style="font-size:0.75rem;color:var(--text-muted);">{{ $exp['start_date'] ?? '' }} - {{ $exp['end_date'] ?? 'Present' }}</p>
                    @if(!empty($exp['description']))
                        <p style="font-size:0.85rem;color:var(--text-muted);margin-top:0.5rem;">{{ $exp['description'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
        @endif

        @if($profile->educations && count($profile->educations) > 0)
        <div class="card">
            <h2 style="font-size:1rem;font-weight:600;margin-bottom:1rem;">Education</h2>
            @foreach($profile->educations as $edu)
                <div style="margin-bottom:1.25rem;@if(!$loop->last)padding-bottom:1.25rem;border-bottom:1px solid var(--border);@endif">
                    <h3 style="font-size:0.95rem;font-weight:600;">{{ $edu['degree'] ?? 'Degree' }}{{ !empty($edu['field_of_study']) ? ' in ' . $edu['field_of_study'] : '' }}</h3>
                    <p style="font-size:0.85rem;color:var(--primary);">{{ $edu['school'] ?? '' }}</p>
                    <p style="font-size:0.75rem;color:var(--text-muted);">{{ $edu['start_date'] ?? '' }} - {{ $edu['end_date'] ?? 'Present' }}</p>
                    @if(!empty($edu['description']))
                        <p style="font-size:0.85rem;color:var(--text-muted);margin-top:0.5rem;">{{ $edu['description'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
        @endif

        @if($profile->certifications && count($profile->certifications) > 0)
        <div class="card">
            <h2 style="font-size:1rem;font-weight:600;margin-bottom:1rem;">Certifications</h2>
            @foreach($profile->certifications as $cert)
                <div style="margin-bottom:0.75rem;@if(!$loop->last)padding-bottom:0.75rem;border-bottom:1px solid var(--border);@endif">
                    <h3 style="font-size:0.9rem;font-weight:600;">{{ $cert['name'] ?? '' }}</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">{{ $cert['issuer'] ?? '' }}{{ !empty($cert['date']) ? ' - ' . $cert['date'] : '' }}</p>
                </div>
            @endforeach
        </div>
        @endif
    </div>

    <div>
        <div class="card">
            <h2 style="font-size:1rem;font-weight:600;margin-bottom:1rem;">Contact</h2>
            <div style="display:flex;flex-direction:column;gap:0.6rem;font-size:0.85rem;">
                @if($profile->email)<div>📧 {{ $profile->email }}</div>@endif
                @if($profile->phone)<div>📱 {{ $profile->phone }}</div>@endif
                @if($profile->address || $profile->city)<div>📍 {{ trim($profile->address . ', ' . $profile->city . ' ' . $profile->state, ', ') }}</div>@endif
                @if($profile->country)<div>🌍 {{ $profile->country }}</div>@endif
            </div>
            @if($profile->linkedin || $profile->github || $profile->website)
            <div style="margin-top:1rem;display:flex;flex-direction:column;gap:0.5rem;font-size:0.85rem;">
                @if($profile->linkedin)<a href="{{ $profile->linkedin }}" target="_blank">LinkedIn</a>@endif
                @if($profile->github)<a href="{{ $profile->github }}" target="_blank">GitHub</a>@endif
                @if($profile->website)<a href="{{ $profile->website }}" target="_blank">Website</a>@endif
            </div>
            @endif
        </div>

        @if($profile->skills && count($profile->skills) > 0)
        <div class="card">
            <h2 style="font-size:1rem;font-weight:600;margin-bottom:0.75rem;">Skills</h2>
            <div style="display:flex;flex-wrap:wrap;gap:0.35rem;">
                @foreach($profile->skills as $skill)
                    <span style="padding:0.2rem 0.6rem;background:#eff6ff;color:#2563eb;border-radius:9999px;font-size:0.75rem;font-weight:500;">{{ $skill }}</span>
                @endforeach
            </div>
        </div>
        @endif

        @if($profile->languages && count($profile->languages) > 0)
        <div class="card">
            <h2 style="font-size:1rem;font-weight:600;margin-bottom:0.75rem;">Languages</h2>
            @foreach($profile->languages as $lang)
                <div style="display:flex;justify-content:space-between;font-size:0.85rem;@if(!$loop->last)margin-bottom:0.35rem;@endif">
                    <span>{{ $lang['language'] ?? '' }}</span>
                    <span style="color:var(--text-muted);">{{ $lang['proficiency'] ?? '' }}</span>
                </div>
            @endforeach
        </div>
        @endif

        @if($profile->references && count($profile->references) > 0)
        <div class="card">
            <h2 style="font-size:1rem;font-weight:600;margin-bottom:0.75rem;">References</h2>
            @foreach($profile->references as $ref)
                <div style="margin-bottom:0.75rem;@if(!$loop->last)padding-bottom:0.75rem;border-bottom:1px solid var(--border);@endif">
                    <div style="font-size:0.85rem;font-weight:600;">{{ $ref['name'] ?? '' }}</div>
                    <div style="font-size:0.8rem;color:var(--text-muted);">{{ $ref['position'] ?? '' }}{{ !empty($ref['company']) ? ' at ' . $ref['company'] : '' }}</div>
                    @if(!empty($ref['email']))<div style="font-size:0.75rem;color:var(--text-muted);">{{ $ref['email'] }}</div>@endif
                </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection