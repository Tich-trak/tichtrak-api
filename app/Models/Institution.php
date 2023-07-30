<?php

namespace App\Models;

use App\Enums\InstitutionTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Institution extends Model {
    use HasUlids, HasFactory, FilterQueryString;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $filters = ['id', 'type', 'alias', 'email', 'is_active', 'state_id', 'country_id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => InstitutionTypeEnum::class,
    ];

    protected function name(): Attribute {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    public function setAliasAttribute($value) {
        $this->attributes['alias'] = strtolower($value);
    }

    public function getAliasAttribute($value) {
        return strtoupper($value);
    }

    /**
     * Get the Admins for the institution.
     */
    public function admins(): HasMany {
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
