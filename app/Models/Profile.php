<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Profile Model
 *
 * Stores resume/profiling data linked to a user.
 * Uses JSON columns for complex nested data like work experiences and educations.
 */
class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'title',
        'summary',
        'linkedin',
        'github',
        'website',
        'skills',
        'work_experiences',
        'educations',
        'certifications',
        'languages',
        'references',
    ];

    protected function casts(): array
    {
        return [
            'skills' => 'array',
            'work_experiences' => 'array',
            'educations' => 'array',
            'certifications' => 'array',
            'languages' => 'array',
            'references' => 'array',
        ];
    }

    /**
     * Get the user that owns this profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}