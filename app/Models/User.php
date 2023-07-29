<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable  implements JWTSubject {
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    protected function password(): Attribute {
        return Attribute::make(
            set: fn ($value) => bcrypt($value),
        );
    }

    /**
     * Check if the user is a System Administrator
     */
    public function isSystemAdmin(): bool {
        if ($this->role === RoleEnum::SuperAdmin) return true;
        else return false;
    }

    /**
     * Check if the user is an Administrator
     */
    public function isAdmin(): bool {
        if ($this->role === RoleEnum::Admin) return true;
        else return false;
    }

    /**
     * Check if user role is the role value provided
     */
    public function hasRole($role): bool {
        if ($this->role === $role) return true;
        else return false;
    }

    /**
     * Get the Details of an Institution Admin
     */
    public function institutionAdmin(): HasOne {
        return $this->hasOne(InstitutionAdmin::class);
    }

    /**
     * Get the Admins created by this user
     */
    public function childAdmin(): HasMany {
        return $this->hasMany(InstitutionAdmin::class, 'owner');
    }

    /**
     * Get the Details of a Student
     */
    public function student(): HasOne {
        return $this->hasOne(Student::class);
    }
}