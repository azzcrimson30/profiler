<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Profile Controller
 *
 * Handles CRUD operations for user profiles/resumes.
 * Accepts structured form data for JSON fields and converts them to arrays before storing.
 */
class ProfileController extends Controller
{
    /**
     * Display a listing of the user's profiles.
     */
    public function index(): View
    {
        $profiles = auth()->user()->profiles()->latest()->get();

        return view('profiles.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new profile.
     */
    public function create(): View
    {
        return view('profiles.create');
    }

    /**
     * Store a newly created profile.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProfile($request);

        $validated['user_id'] = auth()->id();
        $validated = $this->processJsonFields($request, $validated);

        Profile::create($validated);

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');
    }

    /**
     * Display the specified profile.
     */
    public function show(Profile $profile): View
    {
        $this->authorizeProfile($profile);

        return view('profiles.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified profile.
     */
    public function edit(Profile $profile): View
    {
        $this->authorizeProfile($profile);

        return view('profiles.edit', compact('profile'));
    }

    /**
     * Update the specified profile.
     */
    public function update(Request $request, Profile $profile): RedirectResponse
    {
        $this->authorizeProfile($profile);

        $validated = $this->validateProfile($request);
        $validated = $this->processJsonFields($request, $validated);

        $profile->update($validated);

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified profile.
     */
    public function destroy(Profile $profile): RedirectResponse
    {
        $this->authorizeProfile($profile);

        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
    }

    /**
     * Generate a resume view from the profile data.
     */
    public function resume(Profile $profile): View
    {
        $this->authorizeProfile($profile);

        return view('profiles.resume', compact('profile'));
    }

    /**
     * Validate base profile fields.
     */
    private function validateProfile(Request $request): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'title' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'github' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            // Skills
            'skills' => ['nullable', 'array'],
            'skills.*' => ['nullable', 'string', 'max:255'],
            // Work experiences
            'work_experiences' => ['nullable', 'array'],
            'work_experiences.*.company' => ['nullable', 'string', 'max:255'],
            'work_experiences.*.position' => ['nullable', 'string', 'max:255'],
            'work_experiences.*.start_date' => ['nullable', 'string', 'max:50'],
            'work_experiences.*.end_date' => ['nullable', 'string', 'max:50'],
            'work_experiences.*.description' => ['nullable', 'string'],
            // Educations
            'educations' => ['nullable', 'array'],
            'educations.*.school' => ['nullable', 'string', 'max:255'],
            'educations.*.degree' => ['nullable', 'string', 'max:255'],
            'educations.*.field_of_study' => ['nullable', 'string', 'max:255'],
            'educations.*.start_date' => ['nullable', 'string', 'max:50'],
            'educations.*.end_date' => ['nullable', 'string', 'max:50'],
            'educations.*.description' => ['nullable', 'string'],
            // Certifications
            'certifications' => ['nullable', 'array'],
            'certifications.*.name' => ['nullable', 'string', 'max:255'],
            'certifications.*.issuer' => ['nullable', 'string', 'max:255'],
            'certifications.*.date' => ['nullable', 'string', 'max:50'],
            // Languages
            'languages' => ['nullable', 'array'],
            'languages.*.language' => ['nullable', 'string', 'max:100'],
            'languages.*.proficiency' => ['nullable', 'string', 'max:100'],
            // References
            'references' => ['nullable', 'array'],
            'references.*.name' => ['nullable', 'string', 'max:255'],
            'references.*.position' => ['nullable', 'string', 'max:255'],
            'references.*.company' => ['nullable', 'string', 'max:255'],
            'references.*.email' => ['nullable', 'email', 'max:255'],
            'references.*.phone' => ['nullable', 'string', 'max:50'],
        ]);
    }

    /**
     * Process and clean up JSON fields from structured form data.
     */
    private function processJsonFields(Request $request, array $validated): array
    {
        // Skills: filter out empty entries
        if ($request->has('skills')) {
            $validated['skills'] = array_values(array_filter($request->input('skills', [])));
            if (empty($validated['skills'])) {
                $validated['skills'] = null;
            }
        }

        // Work experiences: filter out empty entries
        if ($request->has('work_experiences')) {
            $experiences = array_values(array_filter($request->input('work_experiences', []), function ($item) {
                return !empty($item['company']) || !empty($item['position']);
            }));
            $validated['work_experiences'] = !empty($experiences) ? $experiences : null;
        }

        // Educations: filter out empty entries
        if ($request->has('educations')) {
            $educations = array_values(array_filter($request->input('educations', []), function ($item) {
                return !empty($item['school']) || !empty($item['degree']);
            }));
            $validated['educations'] = !empty($educations) ? $educations : null;
        }

        // Certifications: filter out empty entries
        if ($request->has('certifications')) {
            $certs = array_values(array_filter($request->input('certifications', []), function ($item) {
                return !empty($item['name']);
            }));
            $validated['certifications'] = !empty($certs) ? $certs : null;
        }

        // Languages: filter out empty entries
        if ($request->has('languages')) {
            $langs = array_values(array_filter($request->input('languages', []), function ($item) {
                return !empty($item['language']);
            }));
            $validated['languages'] = !empty($langs) ? $langs : null;
        }

        // References: filter out empty entries
        if ($request->has('references')) {
            $refs = array_values(array_filter($request->input('references', []), function ($item) {
                return !empty($item['name']);
            }));
            $validated['references'] = !empty($refs) ? $refs : null;
        }

        return $validated;
    }

    /**
     * Ensure the profile belongs to the authenticated user.
     */
    private function authorizeProfile(Profile $profile): void
    {
        if ($profile->user_id !== auth()->id()) {
            abort(403, 'Unauthorized. This profile does not belong to you.');
        }
    }
}