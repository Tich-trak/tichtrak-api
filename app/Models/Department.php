<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Department extends Model {
    use HasUlids, HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the faculty that owns the department.
     */
    public function faculty(): BelongsTo {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the programmes for this departments.
     */
    public function programmes(): HasMany {
        return $this->hasMany(Programme::class);
    }


    /**
     * Get all of the courses for the department through the programmme.
     */
    public function courses(): HasManyThrough {
        return $this->hasManyThrough(Course::class, Programme::class);
    }
}
