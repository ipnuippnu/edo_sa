<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\HasRolePermission;
use App\Models\Traits\Ulids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, Ulids, HasRolePermission;

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // protected function getDefaultGuardName(): string
    // {
    //     return 'web';
    // }

    public function personal() : HasOne
    {
        return $this->hasOne(PersonalInformation::class);
    }

    public function getProfilePictureAttribute()
    {
        if($this->picture != null && Storage::disk('profile')->exists($this->picture))
            return Storage::disk('profile')->url($this->picture);

        return asset('assets/images/user.png');
    }

    public function education_histories() : HasMany
    {
        return $this->hasMany(EducationHistory::class);
    }

    public function trainings() : BelongsToMany
    {
        return $this->belongsToMany(Training::class, 'user_training');
    }

    public function banom() : Attribute
    {
        return Attribute::get(fn() =>match($this->personal?->gender)
        {
            'L' => 'IPNU',
            'P' => 'IPPNU',
            
            default => null

        });
    }

}
