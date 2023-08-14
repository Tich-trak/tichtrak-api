<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Programme extends Model {
    use HasUlids, HasFactory, FilterQueryString;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['department', 'students'];


    /**
     * Get the department that owns the programme.
     */
    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the students of this programme;
     */
    public function students(): HasMany {
        return $this->hasMany(Student::class);
    }
}
