<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'born_date' => 'date'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bornPlace() : Attribute
    {
        return Attribute::make(set: fn(string $value) => ucwords(strtolower($value)));
    }

    public function phone() : Attribute
    {
        return Attribute::make(set: fn(string $value) => str_replace('+', '', $value));
    }

    public function dusun(): Attribute
    {
        return Attribute::set(fn($val) => Str::upper($val));
    }

    public function rt(): Attribute
    {
        return Attribute::set(fn($val) => Str::padLeft((int) $val, 3, '0'));
    }

    public function rw(): Attribute
    {
        return Attribute::set(fn($val) => Str::padLeft((int) $val, 3, '0'));
    }
}
