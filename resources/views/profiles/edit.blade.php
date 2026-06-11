@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
<div class="page-header">
    <h1>Edit Profile</h1>
    <p>Update profile for <strong>{{ $profile->first_name }} {{ $profile->last_name }}</strong></p>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="m-0" style="padding-left:1.2rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('profiles.update', $profile) }}" id="profileForm" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
        <h2 class="section-title">Personal Information</h2>
        <div class="grid-cols-2">
            <div class="form-group"><label for="first_name">First Name *</label><input type="text" id="first_name" name="first_name" class="form-input" value="{{ old('first_name', $profile->first_name) }}" required></div>
            <div class="form-group"><label for="last_name">Last Name *</label><input type="text" id="last_name" name="last_name" class="form-input" value="{{ old('last_name', $profile->last_name) }}" required></div>
        </div>
        <div class="grid-cols-2">
            <div class="form-group"><label for="email">Email</label><input type="email" id="email" name="email" class="form-input" value="{{ old('email', $profile->email) }}"></div>
            <div class="form-group"><label for="phone">Phone</label><input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone', $profile->phone) }}"></div>
        </div>
        <div class="form-group"><label for="address">Address</label><input type="text" id="address" name="address" class="form-input" value="{{ old('address', $profile->address) }}"></div>
        <div class="grid-cols-3">
            <div class="form-group"><label for="city">City</label><input type="text" id="city" name="city" class="form-input" value="{{ old('city', $profile->city) }}"></div>
            <div class="form-group"><label for="state">State</label><input type="text" id="state" name="state" class="form-input" value="{{ old('state', $profile->state) }}"></div>
            <div class="form-group"><label for="zip_code">Zip Code</label><input type="text" id="zip_code" name="zip_code" class="form-input" value="{{ old('zip_code', $profile->zip_code) }}"></div>
        </div>
        <div class="form-group"><label for="country">Country</label><input type="text" id="country" name="country" class="form-input" value="{{ old('country', $profile->country) }}"></div>

        <div class="form-group">
            <label for="avatar">Photo</label>
            @if($profile->avatar)
                <div class="d-flex gap-0.5 align-center mb-0.5">
                    <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Profile photo" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">
                    <label class="small-muted"><input type="checkbox" name="avatar_remove" value="1"> Remove photo</label>
                </div>
            @endif
            <input type="file" id="avatar" name="avatar" accept="image/*">
        </div>
    </div>

    <div class="card">
        <h2 class="section-title">Professional Information</h2>
        <div class="form-group"><label for="title">Professional Title</label><input type="text" id="title" name="title" class="form-input" value="{{ old('title', $profile->title) }}"></div>
        <div class="form-group"><label for="summary">Professional Summary</label><textarea id="summary" name="summary" class="form-textarea" rows="4">{{ old('summary', $profile->summary) }}</textarea></div>
    </div>

    <div class="card">
        <h2 class="section-title">Skills</h2>
        <p class="form-muted mb-1">Enter your skills one at a time.</p>
        <div id="skills-container">
            @php $skills = $profile->skills ?? []; @endphp
            @forelse($skills as $skill)
                <div class="skill-entry d-flex gap-0.5 mb-0.5 align-center">
                    <input type="text" name="skills[]" value="{{ $skill }}" class="form-input flex-1">
                    <button type="button" class="btn btn-danger btn-sm remove-skill {{ count($skills) <= 1 ? 'd-none' : '' }}">✕</button>
                </div>
            @empty
                <div class="skill-entry d-flex gap-0.5 mb-0.5 align-center">
                    <input type="text" name="skills[]" placeholder="e.g. PHP" class="form-input flex-1">
                    <button type="button" class="btn btn-danger btn-sm remove-skill d-none">✕</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-skill">+ Add Skill</button>
    </div>

    <div class="card">
        <h2 class="section-title">Work Experiences</h2>
        <p class="form-muted mb-1">Add your work history.</p>
        <div id="work-experiences-container">
            @php $experiences = $profile->work_experiences ?? []; @endphp
            @forelse($experiences as $i => $exp)
                <div class="work-entry card-inset">
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Company</label><input type="text" name="work_experiences[{{ $i }}][company]" class="form-input" value="{{ $exp['company'] ?? '' }}" placeholder="Company name"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Position</label><input type="text" name="work_experiences[{{ $i }}][position]" class="form-input" value="{{ $exp['position'] ?? '' }}" placeholder="Job title"></div>
                    </div>
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Start Date</label><input type="text" name="work_experiences[{{ $i }}][start_date]" class="form-input" value="{{ $exp['start_date'] ?? '' }}" placeholder="e.g. 2020-01"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">End Date</label><input type="text" name="work_experiences[{{ $i }}][end_date]" class="form-input" value="{{ $exp['end_date'] ?? '' }}" placeholder="e.g. 2023-12"></div>
                    </div>
                    <div class="form-group form-mb-0.5"><label class="form-label-sm">Description</label><textarea name="work_experiences[{{ $i }}][description]" class="form-textarea" rows="2" placeholder="Describe your responsibilities">{{ $exp['description'] ?? '' }}</textarea></div>
                    <button type="button" class="btn btn-danger btn-sm remove-work {{ count($experiences) <= 1 ? 'd-none' : '' }}">Remove</button>
                </div>
            @empty
                <div class="work-entry card-inset">
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Company</label><input type="text" name="work_experiences[0][company]" class="form-input" placeholder="Company name"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Position</label><input type="text" name="work_experiences[0][position]" class="form-input" placeholder="Job title"></div>
                    </div>
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Start Date</label><input type="text" name="work_experiences[0][start_date]" class="form-input" placeholder="e.g. 2020-01"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">End Date</label><input type="text" name="work_experiences[0][end_date]" class="form-input" placeholder="e.g. 2023-12"></div>
                    </div>
                    <div class="form-group form-mb-0.5"><label class="form-label-sm">Description</label><textarea name="work_experiences[0][description]" class="form-textarea" rows="2" placeholder="Describe your responsibilities"></textarea></div>
                    <button type="button" class="btn btn-danger btn-sm remove-work d-none">Remove</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-work">+ Add Experience</button>
    </div>

    <div class="card">
        <h2 class="section-title">Educations</h2>
        <p class="form-muted mb-1">Add your educational background.</p>
        <div id="educations-container">
            @php $educationList = $profile->educations ?? []; @endphp
            @forelse($educationList as $i => $edu)
                <div class="education-entry card-inset">
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">School</label><input type="text" name="educations[{{ $i }}][school]" class="form-input" value="{{ $edu['school'] ?? '' }}" placeholder="University name"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Degree</label><input type="text" name="educations[{{ $i }}][degree]" class="form-input" value="{{ $edu['degree'] ?? '' }}" placeholder="e.g. BSc"></div>
                    </div>
                    <div class="grid-cols-3">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Field of Study</label><input type="text" name="educations[{{ $i }}][field_of_study]" class="form-input" value="{{ $edu['field_of_study'] ?? '' }}" placeholder="Major"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Start Date</label><input type="text" name="educations[{{ $i }}][start_date]" class="form-input" value="{{ $edu['start_date'] ?? '' }}" placeholder="e.g. 2016"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">End Date</label><input type="text" name="educations[{{ $i }}][end_date]" class="form-input" value="{{ $edu['end_date'] ?? '' }}" placeholder="e.g. 2020"></div>
                    </div>
                    <div class="form-group form-mb-0.5"><label class="form-label-sm">Description</label><textarea name="educations[{{ $i }}][description]" class="form-textarea" rows="2" placeholder="Additional details">{{ $edu['description'] ?? '' }}</textarea></div>
                    <button type="button" class="btn btn-danger btn-sm remove-education {{ count($educationList) <= 1 ? 'd-none' : '' }}">Remove</button>
                </div>
            @empty
                <div class="education-entry card-inset">
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">School</label><input type="text" name="educations[0][school]" class="form-input" placeholder="University name"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Degree</label><input type="text" name="educations[0][degree]" class="form-input" placeholder="e.g. BSc"></div>
                    </div>
                    <div class="grid-cols-3">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Field of Study</label><input type="text" name="educations[0][field_of_study]" class="form-input" placeholder="Major"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Start Date</label><input type="text" name="educations[0][start_date]" class="form-input" placeholder="e.g. 2016"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">End Date</label><input type="text" name="educations[0][end_date]" class="form-input" placeholder="e.g. 2020"></div>
                    </div>
                    <div class="form-group form-mb-0.5"><label class="form-label-sm">Description</label><textarea name="educations[0][description]" class="form-textarea" rows="2" placeholder="Additional details"></textarea></div>
                    <button type="button" class="btn btn-danger btn-sm remove-education d-none">Remove</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-education">+ Add Education</button>
    </div>

    <div class="card">
        <h2 class="section-title">Certifications</h2>
        <div id="certifications-container">
            @php $certList = $profile->certifications ?? []; @endphp
            @forelse($certList as $i => $cert)
                <div class="certification-entry card-inset">
                    <div class="grid-cols-3">
                        <div class="form-group form-mb-0"><label class="form-label-sm">Name</label><input type="text" name="certifications[{{ $i }}][name]" class="form-input" value="{{ $cert['name'] ?? '' }}" placeholder="Cert name"></div>
                        <div class="form-group form-mb-0"><label class="form-label-sm">Issuer</label><input type="text" name="certifications[{{ $i }}][issuer]" class="form-input" value="{{ $cert['issuer'] ?? '' }}" placeholder="Issuing org"></div>
                        <div class="form-group form-mb-0"><label class="form-label-sm">Date</label><input type="text" name="certifications[{{ $i }}][date]" class="form-input" value="{{ $cert['date'] ?? '' }}" placeholder="e.g. 2023"></div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-certification {{ count($certList) <= 1 ? 'd-none' : '' }} mt-0.5">Remove</button>
                </div>
            @empty
                <div class="certification-entry card-inset">
                    <div class="grid-cols-3">
                        <div class="form-group form-mb-0"><label class="form-label-sm">Name</label><input type="text" name="certifications[0][name]" class="form-input" placeholder="Cert name"></div>
                        <div class="form-group form-mb-0"><label class="form-label-sm">Issuer</label><input type="text" name="certifications[0][issuer]" class="form-input" placeholder="Issuing org"></div>
                        <div class="form-group form-mb-0"><label class="form-label-sm">Date</label><input type="text" name="certifications[0][date]" class="form-input" placeholder="e.g. 2023"></div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-certification d-none mt-0.5">Remove</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-certification">+ Add Certification</button>
    </div>

    <div class="card">
        <h2 class="section-title">Languages</h2>
        <div id="languages-container">
            @php $langList = $profile->languages ?? []; @endphp
            @forelse($langList as $i => $lang)
                <div class="language-entry card-inset">
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0"><label class="form-label-sm">Language</label><input type="text" name="languages[{{ $i }}][language]" class="form-input" value="{{ $lang['language'] ?? '' }}" placeholder="e.g. English"></div>
                        <div class="form-group form-mb-0"><label class="form-label-sm">Proficiency</label>
                            <select name="languages[{{ $i }}][proficiency]" class="form-select">
                                <option value="">Select...</option>
                                @foreach(['Native','Fluent','Advanced','Intermediate','Basic'] as $level)
                                    <option value="{{ $level }}" {{ ($lang['proficiency'] ?? '') === $level ? 'selected' : '' }}>{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-language {{ count($langList) <= 1 ? 'd-none' : '' }} mt-0.5">Remove</button>
                </div>
            @empty
                <div class="language-entry card-inset">
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0"><label class="form-label-sm">Language</label><input type="text" name="languages[0][language]" class="form-input" placeholder="e.g. English"></div>
                        <div class="form-group form-mb-0"><label class="form-label-sm">Proficiency</label>
                            <select name="languages[0][proficiency]" class="form-select">
                                <option value="">Select...</option>
                                @foreach(['Native','Fluent','Advanced','Intermediate','Basic'] as $level)
                                    <option value="{{ $level }}">{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-language d-none mt-0.5">Remove</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-language">+ Add Language</button>
    </div>

    <div class="card">
        <h2 class="section-title">References</h2>
        <div id="references-container">
            @php $refList = $profile->references ?? []; @endphp
            @forelse($refList as $i => $ref)
                <div class="reference-entry card-inset">
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Name</label><input type="text" name="references[{{ $i }}][name]" class="form-input" value="{{ $ref['name'] ?? '' }}" placeholder="Full name"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Position</label><input type="text" name="references[{{ $i }}][position]" class="form-input" value="{{ $ref['position'] ?? '' }}" placeholder="Job title"></div>
                    </div>
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Company</label><input type="text" name="references[{{ $i }}][company]" class="form-input" value="{{ $ref['company'] ?? '' }}" placeholder="Company name"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Email</label><input type="email" name="references[{{ $i }}][email]" class="form-input" value="{{ $ref['email'] ?? '' }}" placeholder="email@example.com"></div>
                    </div>
                    <div class="form-group form-mb-0"><label class="form-label-sm">Phone</label><input type="text" name="references[{{ $i }}][phone]" class="form-input" value="{{ $ref['phone'] ?? '' }}" placeholder="Phone number"></div>
                    <button type="button" class="btn btn-danger btn-sm remove-reference {{ count($refList) <= 1 ? 'd-none' : '' }} mt-0.5">Remove</button>
                </div>
            @empty
                <div class="reference-entry card-inset">
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Name</label><input type="text" name="references[0][name]" class="form-input" placeholder="Full name"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Position</label><input type="text" name="references[0][position]" class="form-input" placeholder="Job title"></div>
                    </div>
                    <div class="grid-cols-2">
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Company</label><input type="text" name="references[0][company]" class="form-input" placeholder="Company name"></div>
                        <div class="form-group form-mb-0.5"><label class="form-label-sm">Email</label><input type="email" name="references[0][email]" class="form-input" placeholder="email@example.com"></div>
                    </div>
                    <div class="form-group form-mb-0"><label class="form-label-sm">Phone</label><input type="text" name="references[0][phone]" class="form-input" placeholder="Phone number"></div>
                    <button type="button" class="btn btn-danger btn-sm remove-reference d-none mt-0.5">Remove</button>
                </div>
            @endforelse
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="add-reference">+ Add Reference</button>
    </div>

    <div class="card">
        <h2 class="section-title">Online Links</h2>
        <div class="grid-cols-3">
            <div class="form-group"><label for="linkedin">LinkedIn</label><input type="url" id="linkedin" name="linkedin" class="form-input" value="{{ old('linkedin', $profile->linkedin) }}" placeholder="https://linkedin.com/in/..."></div>
            <div class="form-group"><label for="github">GitHub</label><input type="url" id="github" name="github" class="form-input" value="{{ old('github', $profile->github) }}" placeholder="https://github.com/..."></div>
            <div class="form-group"><label for="website">Website</label><input type="url" id="website" name="website" class="form-input" value="{{ old('website', $profile->website) }}" placeholder="https://..."></div>
        </div>
    </div>

    <div class="d-flex gap-0.75 mb-2">
        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const skillsContainer = document.getElementById('skills-container');
    document.getElementById('add-skill').addEventListener('click', function () {
        const entry = document.createElement('div');
        entry.className = 'skill-entry d-flex gap-0.5 mb-0.5 align-center';
        entry.innerHTML = `<input type="text" name="skills[]" placeholder="e.g. PHP" class="form-input flex-1"><button type="button" class="btn btn-danger btn-sm remove-skill">✕</button>`;
        skillsContainer.appendChild(entry);
        updateSkillRemoveButtons();
    });
    skillsContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-skill')) { e.target.closest('.skill-entry').remove(); updateSkillRemoveButtons(); }
    });
    function updateSkillRemoveButtons() {
        const entries = skillsContainer.querySelectorAll('.skill-entry');
        entries.forEach((entry, i) => { const btn = entry.querySelector('.remove-skill'); if (btn) btn.classList.toggle('d-none', entries.length <= 1); });
    }
    updateSkillRemoveButtons();

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
            if (removeBtn) removeBtn.classList.remove('d-none');
            container.appendChild(clone); index++;
            updateRemove(container, entryClass, removeBtnClass);
        });
        container.addEventListener('click', function (e) {
            if (e.target.classList.contains(removeBtnClass)) {
                const entries = container.querySelectorAll('.' + entryClass);
                if (entries.length > 1) { e.target.closest('.' + entryClass).remove(); updateRemove(container, entryClass, removeBtnClass); }
            }
        });
        function updateRemove(container, entryClass, removeBtnClass) {
            const entries = container.querySelectorAll('.' + entryClass);
            entries.forEach((entry, i) => { const btn = entry.querySelector('.' + removeBtnClass); if (btn) btn.classList.toggle('d-none', entries.length <= 1); });
        }
        updateRemove(container, entryClass, removeBtnClass);
    }
    setupDynamicFields('work-experiences-container', 'add-work', 'work-entry', 'remove-work');
    setupDynamicFields('educations-container', 'add-education', 'education-entry', 'remove-education');
    setupDynamicFields('certifications-container', 'add-certification', 'certification-entry', 'remove-certification');
    setupDynamicFields('languages-container', 'add-language', 'language-entry', 'remove-language');
    setupDynamicFields('references-container', 'add-reference', 'reference-entry', 'remove-reference');
});
</script>
@endpush