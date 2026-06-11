<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Role Model
 *
 * Represents a user role (e.g., administrator, commoner).
 */
class Role extends Model
{
    protected $fillable = ['name', 'slug'];

    /**
     * Get the users that have this role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if this is the administrator role.
     */
    public function isAdministrator(): bool
    {
        return $this->slug === 'administrator';
    }
}