<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume - {{ $profile->first_name }} {{ $profile->last_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: #1e293b; line-height: 1.6; background: #fff; }
        .resume { max-width: 800px; margin: 0 auto; padding: 2.5rem 3rem; }
        .resume-header { text-align: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 2px solid #e2e8f0; }
        .resume-header h1 { font-size: 2rem; font-weight: 700; letter-spacing: -0.025em; margin-bottom: 0.25rem; }
        .resume-header .title { font-size: 1.1rem; color: #2563eb; font-weight: 500; margin-bottom: 0.75rem; }
        .resume-header .contact { display: flex; justify-content: center; flex-wrap: wrap; gap: 1rem; font-size: 0.85rem; color: #64748b; }
        .resume-header .contact span { white-space: nowrap; }
        .section { margin-bottom: 1.75rem; }
        .section h2 { font-size: 1.1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #2563eb; padding-bottom: 0.4rem; border-bottom: 1px solid #e2e8f0; margin-bottom: 1rem; }
        .section p { font-size: 0.9rem; color: #475569; line-height: 1.7; }
        .entry { margin-bottom: 1rem; }
        .entry:last-child { margin-bottom: 0; }
        .entry-header { display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; margin-bottom: 0.15rem; }
        .entry-header h3 { font-size: 0.95rem; font-weight: 600; }
        .entry-header .date { font-size: 0.8rem; color: #94a3b8; }
        .entry-sub { font-size: 0.85rem; color: #2563eb; font-weight: 500; }
        .entry-desc { font-size: 0.85rem; color: #475569; margin-top: 0.35rem; }
        .skills-grid { display: flex; flex-wrap: wrap; gap: 0.4rem; }
        .skill-tag { padding: 0.2rem 0.65rem; background: #f1f5f9; border-radius: 9999px; font-size: 0.8rem; font-weight: 500; color: #334155; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .ref-entry { font-size: 0.85rem; }
        .ref-entry strong { font-weight: 600; }
        .ref-entry .ref-detail { color: #64748b; font-size: 0.8rem; }
        .print-btn { position: fixed; top: 1rem; right: 1rem; padding: 0.5rem 1.25rem; background: #2563eb; color: #fff; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; font-family: inherit; z-index: 100; box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
        .print-btn:hover { background: #1d4ed8; }
        @media print { .print-btn { display: none; } body { background: #fff; } .resume { margin: 0; padding: 1.5rem 2rem; } }
        @media (max-width: 600px) { .resume { padding: 1.5rem; } .two-col { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨️ Print / Save PDF</button>

    <div class="resume">
        <div class="resume-header">
            @php $avatar = $profile->avatar ?? ($profile->user->avatar ?? null); @endphp
            @if($avatar)
                <div style="margin-bottom:1rem;">
                    <img src="{{ asset('storage/' . $avatar) }}" alt="Photo" style="width:96px;height:96px;object-fit:cover;border-radius:12px;display:block;margin:0 auto 0.75rem;">
                </div>
            @endif
            <h1>{{ $profile->first_name }} {{ $profile->last_name }}</h1>
            @if($profile->title)<div class="title">{{ $profile->title }}</div>@endif
            <div class="contact">
                @if($profile->email)<span>{{ $profile->email }}</span>@endif
                @if($profile->phone)<span>{{ $profile->phone }}</span>@endif
                @if($profile->city || $profile->state)<span>{{ trim($profile->city . ', ' . $profile->state . ' ' . $profile->zip_code, ', ') }}</span>@endif
                @if($profile->country)<span>{{ $profile->country }}</span>@endif
            </div>
            @if($profile->linkedin || $profile->github || $profile->website)
            <div class="contact" style="margin-top:0.5rem;">
                @if($profile->linkedin)<span><a href="{{ $profile->linkedin }}" style="color:#2563eb;text-decoration:none;">LinkedIn</a></span>@endif
                @if($profile->github)<span><a href="{{ $profile->github }}" style="color:#2563eb;text-decoration:none;">GitHub</a></span>@endif
                @if($profile->website)<span><a href="{{ $profile->website }}" style="color:#2563eb;text-decoration:none;">Website</a></span>@endif
            </div>
            @endif
        </div>

        @if($profile->summary)
        <div class="section">
            <h2>Professional Summary</h2>
            <p>{{ $profile->summary }}</p>
        </div>
        @endif

        @if($profile->work_experiences && count($profile->work_experiences) > 0)
        <div class="section">
            <h2>Work Experience</h2>
            @foreach($profile->work_experiences as $exp)
                <div class="entry">
                    <div class="entry-header">
                        <h3>{{ $exp['position'] ?? 'Position' }}</h3>
                        <span class="date">{{ $exp['start_date'] ?? '' }} - {{ $exp['end_date'] ?? 'Present' }}</span>
                    </div>
                    <div class="entry-sub">{{ $exp['company'] ?? '' }}</div>
                    @if(!empty($exp['description']))<div class="entry-desc">{{ $exp['description'] }}</div>@endif
                </div>
            @endforeach
        </div>
        @endif

        @if($profile->educations && count($profile->educations) > 0)
        <div class="section">
            <h2>Education</h2>
            @foreach($profile->educations as $edu)
                <div class="entry">
                    <div class="entry-header">
                        <h3>{{ $edu['degree'] ?? 'Degree' }}{{ !empty($edu['field_of_study']) ? ' in ' . $edu['field_of_study'] : '' }}</h3>
                        <span class="date">{{ $edu['start_date'] ?? '' }} - {{ $edu['end_date'] ?? 'Present' }}</span>
                    </div>
                    <div class="entry-sub">{{ $edu['school'] ?? '' }}</div>
                    @if(!empty($edu['description']))<div class="entry-desc">{{ $edu['description'] }}</div>@endif
                </div>
            @endforeach
        </div>
        @endif

        @if($profile->skills && count($profile->skills) > 0)
        <div class="section">
            <h2>Skills</h2>
            <div class="skills-grid">
                @foreach($profile->skills as $skill)
                    <span class="skill-tag">{{ $skill }}</span>
                @endforeach
            </div>
        </div>
        @endif

        @if($profile->certifications && count($profile->certifications) > 0)
        <div class="section">
            <h2>Certifications</h2>
            @foreach($profile->certifications as $cert)
                <div class="entry">
                    <div class="entry-header">
                        <h3>{{ $cert['name'] ?? '' }}</h3>
                        <span class="date">{{ $cert['date'] ?? '' }}</span>
                    </div>
                    <div class="entry-sub">{{ $cert['issuer'] ?? '' }}</div>
                </div>
            @endforeach
        </div>
        @endif

        @if($profile->languages && count($profile->languages) > 0)
        <div class="section">
            <h2>Languages</h2>
            <div class="two-col">
                @foreach($profile->languages as $lang)
                    <div><strong>{{ $lang['language'] ?? '' }}</strong> - {{ $lang['proficiency'] ?? '' }}</div>
                @endforeach
            </div>
        </div>
        @endif

        @if($profile->references && count($profile->references) > 0)
        <div class="section">
            <h2>References</h2>
            <div class="two-col">
                @foreach($profile->references as $ref)
                    <div class="ref-entry">
                        <strong>{{ $ref['name'] ?? '' }}</strong><br>
                        <span class="ref-detail">{{ $ref['position'] ?? '' }}{{ !empty($ref['company']) ? ' at ' . $ref['company'] : '' }}</span><br>
                        @if(!empty($ref['email']))<span class="ref-detail">{{ $ref['email'] }}</span><br>@endif
                        @if(!empty($ref['phone']))<span class="ref-detail">{{ $ref['phone'] }}</span>@endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</body>
</html>