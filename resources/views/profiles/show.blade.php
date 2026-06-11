@extends('layouts.dashboard')

@section('title', $profile->first_name . ' ' . $profile->last_name . ' - Profile')

@section('content')
<div class="page-header flex-between-wrap">
    <div>
        <h1>{{ $profile->first_name }} {{ $profile->last_name }}</h1>
        @if($profile->title)<p>{{ $profile->title }}</p>@endif
    </div>
    <div class="d-flex gap-0.5">
        <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('profiles.resume', $profile) }}" class="btn btn-primary" target="_blank">Generate Resume</a>
    </div>
</div>

<div class="grid-2-1">
    <div>
        @if($profile->summary)
        <div class="card">
            <h2 class="card-section-title">Professional Summary</h2>
            <p class="card-text">{{ $profile->summary }}</p>
        </div>
        @endif

        @if($profile->work_experiences && count($profile->work_experiences) > 0)
        <div class="card">
            <h2 class="card-section-title">Work Experience</h2>
            @foreach($profile->work_experiences as $exp)
                <div class="entry">
                    <h3 class="entry-title">{{ $exp['position'] ?? 'Position' }}</h3>
                    <p class="entry-company">{{ $exp['company'] ?? '' }}</p>
                    <p class="entry-dates">{{ $exp['start_date'] ?? '' }} - {{ $exp['end_date'] ?? 'Present' }}</p>
                    @if(!empty($exp['description']))
                        <p class="entry-desc">{{ $exp['description'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
        @endif

        @if($profile->educations && count($profile->educations) > 0)
        <div class="card">
            <h2 class="card-section-title">Education</h2>
            @foreach($profile->educations as $edu)
                <div class="entry">
                    <h3 class="entry-title">{{ $edu['degree'] ?? 'Degree' }}{{ !empty($edu['field_of_study']) ? ' in ' . $edu['field_of_study'] : '' }}</h3>
                    <p class="entry-company">{{ $edu['school'] ?? '' }}</p>
                    <p class="entry-dates">{{ $edu['start_date'] ?? '' }} - {{ $edu['end_date'] ?? 'Present' }}</p>
                    @if(!empty($edu['description']))
                        <p class="entry-desc">{{ $edu['description'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
        @endif

        @if($profile->certifications && count($profile->certifications) > 0)
        <div class="card">
            <h2 class="card-section-title">Certifications</h2>
            @foreach($profile->certifications as $cert)
                <div class="cert-entry">
                    <h3 class="cert-title">{{ $cert['name'] ?? '' }}</h3>
                    <p class="cert-meta">{{ $cert['issuer'] ?? '' }}{{ !empty($cert['date']) ? ' - ' . $cert['date'] : '' }}</p>
                </div>
            @endforeach
        </div>
        @endif
    </div>

    <div>
        <div class="card">
            <h2 class="card-section-title">Contact</h2>
            <div class="contact-list">
                @if($profile->email)<div>📧 {{ $profile->email }}</div>@endif
                @if($profile->phone)<div>📱 {{ $profile->phone }}</div>@endif
                @if($profile->address || $profile->city)<div>📍 {{ trim($profile->address . ', ' . $profile->city . ' ' . $profile->state, ', ') }}</div>@endif
                @if($profile->country)<div>🌍 {{ $profile->country }}</div>@endif
            </div>
            @if($profile->linkedin || $profile->github || $profile->website)
            <div class="links-list">
                @if($profile->linkedin)<a href="{{ $profile->linkedin }}" target="_blank">LinkedIn</a>@endif
                @if($profile->github)<a href="{{ $profile->github }}" target="_blank">GitHub</a>@endif
                @if($profile->website)<a href="{{ $profile->website }}" target="_blank">Website</a>@endif
            </div>
            @endif
        </div>

        @if($profile->skills && count($profile->skills) > 0)
        <div class="card">
            <h2 class="card-section-title">Skills</h2>
            <div class="skills-wrap">
                @foreach($profile->skills as $skill)
                    <span class="skill-badge">{{ $skill }}</span>
                @endforeach
            </div>
        </div>
        @endif

        @if($profile->languages && count($profile->languages) > 0)
        <div class="card">
            <h2 class="card-section-title">Languages</h2>
            @foreach($profile->languages as $lang)
                <div class="lang-row">
                    <span>{{ $lang['language'] ?? '' }}</span>
                    <span class="entry-dates">{{ $lang['proficiency'] ?? '' }}</span>
                </div>
            @endforeach
        </div>
        @endif

        @if($profile->references && count($profile->references) > 0)
        <div class="card">
            <h2 class="card-section-title">References</h2>
            @foreach($profile->references as $ref)
                <div class="ref-entry">
                    <div class="ref-name">{{ $ref['name'] ?? '' }}</div>
                    <div class="ref-meta">{{ $ref['position'] ?? '' }}{{ !empty($ref['company']) ? ' at ' . $ref['company'] : '' }}</div>
                    @if(!empty($ref['email']))<div class="ref-email">{{ $ref['email'] }}</div>@endif
                </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection