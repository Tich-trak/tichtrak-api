<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Course extends Model {
    use HasUlids, HasFactory, FilterQueryString;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $filters = ['id', 'level_id'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['level']; //TODO add department later

    /**
     * Get the level that owns the course.
     */
    public function level(): BelongsTo {
        return $this->belongsTo(Level::class);
    }

    /**
     * Get All Departments that take this course
     */
    public function departments() {
        return $this->belongsToMany(Department::class, 'course_department');
    }
}
