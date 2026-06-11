@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
<div class="page-header">
    <h1>Edit Profile</h1>
    <p>Update profile for <strong>{{ $profile->first_name }} {{ $profile->last_name }}</strong></p>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul style="margin:0;padding-left:1.2rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('profiles.update', $profile) }}" id="profileForm">
    @csrf
    @method('PUT')

    {{-- Personal Information --}}
    <div class="card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:1.25rem;">Personal Information</h2>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group"><label for="first_name">First Name *</label><input type="text" id="first_name" name="first_name" value="{{ old('first_name', $profile->first_name) }}" required></div>
            <div class="form-group"><label for="last_name">Last Name *</label><input type="text" id="last_name" name="last_name" value="{{ old('last_name', $profile->last_name) }}" required></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group"><label for="email">Email</label><input type="email" id="email" name="email" value="{{ old('email', $profile->email) }}"></div>
            <div class="form-group"><label for="phone">Phone</label><input type="text" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}"></div>
        </div>
        <div class="form-group"><label for="address">Address</label><input type="text" id="address" name="address" value="{{ old('address', $profile->address) }}"></div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
            <div class="form-group"><label for="city">City</label><input type="text" id="city" name="city" value="{{ old('city', $profile->city) }}"></div>
            <div class="form-group"><label for="state">State</label><input type="text" id="state" name="state" value="{{ old('state', $profile->state) }}"></div>
            <div class="form-group"><label for="zip_code">Zip Code</label><input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code', $profile->zip_code) }}"></div>
        </div>
        <div class="form-group"><label for="country">Country</label><input type="text" id="country" name="country" value="{{ old('country', $profile->country) }}"></div>
    </div>

    {{-- Professional Information --}}
    <div class="card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:1.25rem;">Professional Information</h2>
        <div class="form-group"><label for="title">Professional Title</label><input type="text" id="title" name="title" value="{{ old('title', $profile->title) }}"></div>
        <div class="form-group">
            <label for="summary">Professional Summary</label>
            <textarea id="summary" name="summary" rows="4" style="width:100%;padding:0.55rem 0.8rem;border:1px solid var(--border);border-radius:8px;font-size:0.875rem;font-family:inherit;resize:vertical;">{{ old('summary', $profile->summary) }}</textarea>
        </div>
    </div>

    {{-- Skills --}}
    <div class="card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:1.25rem;">Skills</h2>
        <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1rem;">Enter your skills one at a time.</p>
        <div id="skills-container">
            @php $skills = $profile->skills ?? []; @endphp
            @forelse($skills as $skill)
                <div class="skill-entry" style="display:flex;gap:0.5rem;margin-bottom:0.5rem;align-items:center;">
                    <input type="text" name="skills[]" value="{{ $skill }}" style="flex:1;padding:0.55rem 0.8rem;border:1px solid var(--border);border-radius:8px;font-size:0.875rem;font-family:inherit;">
                    <button type="button" class="btn btn-danger btn-sm remove-skill" style="display:{{ $loop->count > 1 ? '' : 'none' }};">✕</button>
                </div>
            @empty
                <div class="skill-entry" style="display:flex;gap:0.5rem;margin-bottom:0.5rem;align-items:center;">
                    <input type="text" name="skills[]" placeholder="e.g. PHP" style="flex:1;padding:0.55rem 0.8rem;border:1px solid var(--border);border-radius:8px;font-size:0.875rem;font-family:inherit;">
                    <button type="button" class="btn btn-danger btn-sm remove-skill" style="display:none;">✕</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-skill">+ Add Skill</button>
    </div>

    {{-- Work Experiences --}}
    <div class="card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:1.25rem;">Work Experiences</h2>
        <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1rem;">Add your work history.</p>
        <div id="work-experiences-container">
            @php $experiences = $profile->work_experiences ?? []; @endphp
            @forelse($experiences as $i => $exp)
                <div class="work-entry" style="padding:1rem;border:1px solid var(--border);border-radius:8px;margin-bottom:1rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Company</label><input type="text" name="work_experiences[{{ $i }}][company]" value="{{ $exp['company'] ?? '' }}" placeholder="Company name"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Position</label><input type="text" name="work_experiences[{{ $i }}][position]" value="{{ $exp['position'] ?? '' }}" placeholder="Job title"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Start Date</label><input type="text" name="work_experiences[{{ $i }}][start_date]" value="{{ $exp['start_date'] ?? '' }}" placeholder="e.g. 2020-01"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">End Date</label><input type="text" name="work_experiences[{{ $i }}][end_date]" value="{{ $exp['end_date'] ?? '' }}" placeholder="e.g. 2023-12"></div>
                    </div>
                    <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Description</label><textarea name="work_experiences[{{ $i }}][description]" rows="2" style="width:100%;padding:0.5rem 0.75rem;border:1px solid var(--border);border-radius:8px;font-size:0.875rem;font-family:inherit;resize:vertical;" placeholder="Describe your responsibilities">{{ $exp['description'] ?? '' }}</textarea></div>
                    <button type="button" class="btn btn-danger btn-sm remove-work" style="display:{{ count($experiences) > 1 ? '' : 'none' }};">Remove</button>
                </div>
            @empty
                <div class="work-entry" style="padding:1rem;border:1px solid var(--border);border-radius:8px;margin-bottom:1rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Company</label><input type="text" name="work_experiences[0][company]" placeholder="Company name"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Position</label><input type="text" name="work_experiences[0][position]" placeholder="Job title"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Start Date</label><input type="text" name="work_experiences[0][start_date]" placeholder="e.g. 2020-01"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">End Date</label><input type="text" name="work_experiences[0][end_date]" placeholder="e.g. 2023-12"></div>
                    </div>
                    <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Description</label><textarea name="work_experiences[0][description]" rows="2" style="width:100%;padding:0.5rem 0.75rem;border:1px solid var(--border);border-radius:8px;font-size:0.875rem;font-family:inherit;resize:vertical;" placeholder="Describe your responsibilities"></textarea></div>
                    <button type="button" class="btn btn-danger btn-sm remove-work" style="display:none;">Remove</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-work">+ Add Experience</button>
    </div>

    {{-- Educations --}}
    <div class="card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:1.25rem;">Educations</h2>
        <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1rem;">Add your educational background.</p>
        <div id="educations-container">
            @php $educationList = $profile->educations ?? []; @endphp
            @forelse($educationList as $i => $edu)
                <div class="education-entry" style="padding:1rem;border:1px solid var(--border);border-radius:8px;margin-bottom:1rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">School</label><input type="text" name="educations[{{ $i }}][school]" value="{{ $edu['school'] ?? '' }}" placeholder="University name"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Degree</label><input type="text" name="educations[{{ $i }}][degree]" value="{{ $edu['degree'] ?? '' }}" placeholder="e.g. BSc"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Field of Study</label><input type="text" name="educations[{{ $i }}][field_of_study]" value="{{ $edu['field_of_study'] ?? '' }}" placeholder="Major"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Start Date</label><input type="text" name="educations[{{ $i }}][start_date]" value="{{ $edu['start_date'] ?? '' }}" placeholder="e.g. 2016"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">End Date</label><input type="text" name="educations[{{ $i }}][end_date]" value="{{ $edu['end_date'] ?? '' }}" placeholder="e.g. 2020"></div>
                    </div>
                    <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Description</label><textarea name="educations[{{ $i }}][description]" rows="2" style="width:100%;padding:0.5rem 0.75rem;border:1px solid var(--border);border-radius:8px;font-size:0.875rem;font-family:inherit;resize:vertical;" placeholder="Additional details">{{ $edu['description'] ?? '' }}</textarea></div>
                    <button type="button" class="btn btn-danger btn-sm remove-education" style="display:{{ count($educationList) > 1 ? '' : 'none' }};">Remove</button>
                </div>
            @empty
                <div class="education-entry" style="padding:1rem;border:1px solid var(--border);border-radius:8px;margin-bottom:1rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">School</label><input type="text" name="educations[0][school]" placeholder="University name"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Degree</label><input type="text" name="educations[0][degree]" placeholder="e.g. BSc"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Field of Study</label><input type="text" name="educations[0][field_of_study]" placeholder="Major"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Start Date</label><input type="text" name="educations[0][start_date]" placeholder="e.g. 2016"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">End Date</label><input type="text" name="educations[0][end_date]" placeholder="e.g. 2020"></div>
                    </div>
                    <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Description</label><textarea name="educations[0][description]" rows="2" style="width:100%;padding:0.5rem 0.75rem;border:1px solid var(--border);border-radius:8px;font-size:0.875rem;font-family:inherit;resize:vertical;" placeholder="Additional details"></textarea></div>
                    <button type="button" class="btn btn-danger btn-sm remove-education" style="display:none;">Remove</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-education">+ Add Education</button>
    </div>

    {{-- Certifications --}}
    <div class="card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:1.25rem;">Certifications</h2>
        <div id="certifications-container">
            @php $certList = $profile->certifications ?? []; @endphp
            @forelse($certList as $i => $cert)
                <div class="certification-entry" style="padding:1rem;border:1px solid var(--border);border-radius:8px;margin-bottom:1rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0;"><label style="font-size:0.8rem;">Name</label><input type="text" name="certifications[{{ $i }}][name]" value="{{ $cert['name'] ?? '' }}" placeholder="Cert name"></div>
                        <div class="form-group" style="margin-bottom:0;"><label style="font-size:0.8rem;">Issuer</label><input type="text" name="certifications[{{ $i }}][issuer]" value="{{ $cert['issuer'] ?? '' }}" placeholder="Issuing org"></div>
                        <div class="form-group" style="margin-bottom:0;"><label style="font-size:0.8rem;">Date</label><input type="text" name="certifications[{{ $i }}][date]" value="{{ $cert['date'] ?? '' }}" placeholder="e.g. 2023"></div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-certification" style="display:{{ count($certList) > 1 ? '' : 'none' }};margin-top:0.5rem;">Remove</button>
                </div>
            @empty
                <div class="certification-entry" style="padding:1rem;border:1px solid var(--border);border-radius:8px;margin-bottom:1rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0;"><label style="font-size:0.8rem;">Name</label><input type="text" name="certifications[0][name]" placeholder="Cert name"></div>
                        <div class="form-group" style="margin-bottom:0;"><label style="font-size:0.8rem;">Issuer</label><input type="text" name="certifications[0][issuer]" placeholder="Issuing org"></div>
                        <div class="form-group" style="margin-bottom:0;"><label style="font-size:0.8rem;">Date</label><input type="text" name="certifications[0][date]" placeholder="e.g. 2023"></div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-certification" style="display:none;margin-top:0.5rem;">Remove</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-certification">+ Add Certification</button>
    </div>

    {{-- Languages --}}
    <div class="card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:1.25rem;">Languages</h2>
        <div id="languages-container">
            @php $langList = $profile->languages ?? []; @endphp
            @forelse($langList as $i => $lang)
                <div class="language-entry" style="padding:1rem;border:1px solid var(--border);border-radius:8px;margin-bottom:1rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0;"><label style="font-size:0.8rem;">Language</label><input type="text" name="languages[{{ $i }}][language]" value="{{ $lang['language'] ?? '' }}" placeholder="e.g. English"></div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label style="font-size:0.8rem;">Proficiency</label>
                            <select name="languages[{{ $i }}][proficiency]" style="width:100%;padding:0.55rem 0.8rem;border:1px solid var(--border);border-radius:8px;font-size:0.875rem;font-family:inherit;">
                                <option value="">Select...</option>
                                @foreach(['Native', 'Fluent', 'Advanced', 'Intermediate', 'Basic'] as $level)
                                    <option value="{{ $level }}" {{ ($lang['proficiency'] ?? '') === $level ? 'selected' : '' }}>{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-language" style="display:{{ count($langList) > 1 ? '' : 'none' }};margin-top:0.5rem;">Remove</button>
                </div>
            @empty
                <div class="language-entry" style="padding:1rem;border:1px solid var(--border);border-radius:8px;margin-bottom:1rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0;"><label style="font-size:0.8rem;">Language</label><input type="text" name="languages[0][language]" placeholder="e.g. English"></div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label style="font-size:0.8rem;">Proficiency</label>
                            <select name="languages[0][proficiency]" style="width:100%;padding:0.55rem 0.8rem;border:1px solid var(--border);border-radius:8px;font-size:0.875rem;font-family:inherit;">
                                <option value="">Select...</option>
                                <option value="Native">Native</option>
                                <option value="Fluent">Fluent</option>
                                <option value="Advanced">Advanced</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Basic">Basic</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-language" style="display:none;margin-top:0.5rem;">Remove</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-language">+ Add Language</button>
    </div>

    {{-- References --}}
    <div class="card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:1.25rem;">References</h2>
        <div id="references-container">
            @php $refList = $profile->references ?? []; @endphp
            @forelse($refList as $i => $ref)
                <div class="reference-entry" style="padding:1rem;border:1px solid var(--border);border-radius:8px;margin-bottom:1rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Name</label><input type="text" name="references[{{ $i }}][name]" value="{{ $ref['name'] ?? '' }}" placeholder="Full name"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Position</label><input type="text" name="references[{{ $i }}][position]" value="{{ $ref['position'] ?? '' }}" placeholder="Job title"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Company</label><input type="text" name="references[{{ $i }}][company]" value="{{ $ref['company'] ?? '' }}" placeholder="Company name"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Email</label><input type="email" name="references[{{ $i }}][email]" value="{{ $ref['email'] ?? '' }}" placeholder="email@example.com"></div>
                    </div>
                    <div class="form-group" style="margin-bottom:0;"><label style="font-size:0.8rem;">Phone</label><input type="text" name="references[{{ $i }}][phone]" value="{{ $ref['phone'] ?? '' }}" placeholder="Phone number"></div>
                    <button type="button" class="btn btn-danger btn-sm remove-reference" style="display:{{ count($refList) > 1 ? '' : 'none' }};margin-top:0.5rem;">Remove</button>
                </div>
            @empty
                <div class="reference-entry" style="padding:1rem;border:1px solid var(--border);border-radius:8px;margin-bottom:1rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Name</label><input type="text" name="references[0][name]" placeholder="Full name"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Position</label><input type="text" name="references[0][position]" placeholder="Job title"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Company</label><input type="text" name="references[0][company]" placeholder="Company name"></div>
                        <div class="form-group" style="margin-bottom:0.5rem;"><label style="font-size:0.8rem;">Email</label><input type="email" name="references[0][email]" placeholder="email@example.com"></div>
                    </div>
                    <div class="form-group" style="margin-bottom:0;"><label style="font-size:0.8rem;">Phone</label><input type="text" name="references[0][phone]" placeholder="Phone number"></div>
                    <button type="button" class="btn btn-danger btn-sm remove-reference" style="display:none;margin-top:0.5rem;">Remove</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-reference">+ Add Reference</button>
    </div>

    {{-- Links --}}
    <div class="card">
        <h2 style="font-size:1rem;font-weight:600;margin-bottom:1.25rem;">Online Links</h2>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
            <div class="form-group"><label for="linkedin">LinkedIn</label><input type="url" id="linkedin" name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}" placeholder="https://linkedin.com/in/..."></div>
            <div class="form-group"><label for="github">GitHub</label><input type="url" id="github" name="github" value="{{ old('github', $profile->github) }}" placeholder="https://github.com/..."></div>
            <div class="form-group"><label for="website">Website</label><input type="url" id="website" name="website" value="{{ old('website', $profile->website) }}" placeholder="https://..."></div>
        </div>
    </div>

    <div style="display:flex;gap:0.75rem;margin-bottom:2rem;">
        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Skills
    const skillsContainer = document.getElementById('skills-container');
    document.getElementById('add-skill').addEventListener('click', function () {
        const entry = document.createElement('div');
        entry.className = 'skill-entry';
        entry.style.cssText = 'display:flex;gap:0.5rem;margin-bottom:0.5rem;align-items:center;';
        entry.innerHTML = `
            <input type="text" name="skills[]" placeholder="e.g. PHP" style="flex:1;padding:0.55rem 0.8rem;border:1px solid var(--border);border-radius:8px;font-size:0.875rem;font-family:inherit;">
            <button type="button" class="btn btn-danger btn-sm remove-skill">✕</button>
        `;
        skillsContainer.appendChild(entry);
        updateSkillRemoveButtons();
    });

    skillsContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-skill')) {
            e.target.closest('.skill-entry').remove();
            updateSkillRemoveButtons();
        }
    });

    function updateSkillRemoveButtons() {
        const entries = skillsContainer.querySelectorAll('.skill-entry');
        entries.forEach((entry, i) => {
            const btn = entry.querySelector('.remove-skill');
            if (btn) btn.style.display = entries.length > 1 ? '' : 'none';
        });
    }
    updateSkillRemoveButtons();

    // Generic function for dynamic fields
    function setupDynamicFields(containerId, addBtnId, entryClass, removeBtnClass) {
        const container = document.getElementById(containerId);
        let index = container.querySelectorAll('.' + entryClass).length;

        document.getElementById(addBtnId).addEventListener('click', function () {
            const template = container.querySelector('.' + entryClass);
            if (!template) return;
            const clone = template.cloneNode(true);
            clone.querySelectorAll('[name]').forEach(function (input) {
                input.name = input.name.replace(/\[\d+\]/g, '[' + index + ']');
                if (input.tagName === 'INPUT' && input.type !== 'hidden') input.value = '';
                if (input.tagName === 'TEXTAREA') input.value = '';
                if (input.tagName === 'SELECT') input.selectedIndex = 0;
            });
            const removeBtn = clone.querySelector('.' + removeBtnClass);
            if (removeBtn) removeBtn.style.display = '';
            container.appendChild(clone);
            index++;
            updateRemoveButtons(container, entryClass, removeBtnClass);
        });

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains(removeBtnClass)) {
                const entries = container.querySelectorAll('.' + entryClass);
                if (entries.length > 1) {
                    e.target.closest('.' + entryClass).remove();
                    updateRemoveButtons(container, entryClass, removeBtnClass);
                }
            }
        });

        function updateRemoveButtons(container, entryClass, removeBtnClass) {
            const entries = container.querySelectorAll('.' + entryClass);
            entries.forEach((entry, i) => {
                const btn = entry.querySelector('.' + removeBtnClass);
                if (btn) btn.style.display = entries.length > 1 ? '' : 'none';
            });
        }
        updateRemoveButtons(container, entryClass, removeBtnClass);
    }

    setupDynamicFields('work-experiences-container', 'add-work', 'work-entry', 'remove-work');
    setupDynamicFields('educations-container', 'add-education', 'education-entry', 'remove-education');
    setupDynamicFields('certifications-container', 'add-certification', 'certification-entry', 'remove-certification');
    setupDynamicFields('languages-container', 'add-language', 'language-entry', 'remove-language');
    setupDynamicFields('references-container', 'add-reference', 'reference-entry', 'remove-reference');
});
</script>
@endpush