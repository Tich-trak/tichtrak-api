<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class InstitutionAdmin extends Model {
    use HasUlids, HasFactory, FilterQueryString;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $filters = ['id', 'user_id', 'institution_id', 'owner'];

    /**
     * Get the user that owns the institution admin.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that created the institution admin.
     */
    public function parent(): BelongsTo {
        return $this->belongsTo(User::class, 'owner');
    }

    /**
     * Get the institution that owns the admin.
     */
    public function institution(): BelongsTo {
        return $this->belongsTo(Institution::class);
    }
}
