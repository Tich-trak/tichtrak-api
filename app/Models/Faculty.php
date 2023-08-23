<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Faculty extends Model {
    use HasUlids, HasFactory, FilterQueryString;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $filters = ['id', 'institution_id', 'name', 'is_active'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['institution'];

    /**
     * Get the institution that owns the faculty.
     */
    public function institution(): BelongsTo {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get the departments for the faculty.
     */
    public function departments(): HasMany {
        return $this->hasMany(Department::class);
    }
}
