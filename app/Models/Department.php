<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Department extends Model {
    use HasUlids, HasFactory, FilterQueryString;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $filters = ['id', 'faculty_id', 'name', 'is_active'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['faculty', 'programmes', 'courses'];

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
     * Get all of the courses for the department;
     */
    public function courses() {
        return $this->belongsToMany(Course::class, 'course_department');
    }
}
