<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Programme extends Model {
    use HasFactory;

    /**
     * Get the department that owns the programme.
     */
    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the courses for this programmes.
     */
    public function courses(): HasMany {
        return $this->hasMany(Course::class);
    }
}
