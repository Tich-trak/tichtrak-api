<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model {
    use HasUlids, HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the programme that owns the course.
     */
    public function programme(): BelongsTo {
        return $this->belongsTo(Programme::class);
    }

    /**
     * Get the level that owns the course.
     */
    public function level(): BelongsTo {
        return $this->belongsTo(Level::class);
    }
}
