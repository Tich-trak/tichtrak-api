<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Level extends Model {
    use HasUlids, HasFactory, FilterQueryString;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $filters = ['id', 'institution_id', 'name', 'code'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['institution']; //TODO Add student to it

    /**
     * Get the institution that owns the faculty.
     */
    public function institution(): BelongsTo {
        return $this->belongsTo(Level::class);
    }

    /**
     * Get all the students of this level;
     */
    public function students(): HasMany {
        return $this->hasMany(Student::class);
    }
}