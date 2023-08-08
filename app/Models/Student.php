<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model {
    use HasUlids, HasFactory;

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
    protected $with = ['programme', 'level',];

    /**
     * Get the user that owns the user.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the programme that owns the user.
     */
    public function programme(): BelongsTo {
        return $this->belongsTo(Programme::class);
    }

    /**
     * Get the programme that owns the user.
     */
    public function level(): BelongsTo {
        return $this->belongsTo(Level::class);
    }
}
