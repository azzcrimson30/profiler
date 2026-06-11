<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FileCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function files(): HasMany
    {
        return $this->hasMany(StoredFile::class);
    }
}
