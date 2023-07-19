<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Institution extends Model {
    use HasFactory;

    /**
     * Get the comments for the blog post.
     */
    public function institutionAdmins(): HasMany {
        return $this->hasMany(InstitutionAdmin::class);
    }

    /**
     * Get the level for this institution.
     */
    public function levels(): HasMany {
        return $this->hasMany(Level::class);
    }

    /**
     * Get the faculties for this institution.
     */
    public function faculties(): HasMany {
        return $this->hasMany(Faculty::class);
    }

    /**
     * Get all of the departments for the institution through the faculty.
     */
    public function departments(): HasManyThrough {
        return $this->hasManyThrough(Department::class, Faculty::class);
    }
}