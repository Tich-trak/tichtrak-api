<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstitutionAdmin extends Model {
    use HasFactory;


    /**
     * Get the user that owns the institution admin.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the institution that owns the admin.
     */
    public function institution(): BelongsTo {
        return $this->belongsTo(Institution::class);
    }
}
