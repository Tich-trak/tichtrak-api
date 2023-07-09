<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoleEnum;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use HasUlids, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'role' => RoleEnum::class,
        'password' => 'hashed',
    ];

    protected function password(): Attribute {
        return Attribute::make(
            set: fn ($value) => bcrypt($value),
        );
    }

    //TODO SET SUPER ADMIN METHOD
    //TODO SET ADMIN METHOD
    //TODO SET ROLE METHOD

    /**
     * Get the Details of an Institution Admin
     */
    public function institutionAdmin(): HasOne {
        return $this->hasOne(InstitutionAdmin::class);
    }

    /**
     * Get the Details of a Student
     */
    public function student(): HasOne {
        return $this->hasOne(Student::class);
    }
}