<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function born_place() : Attribute
    {
        return Attribute::make(set: fn(string $value) => ucwords(strtolower($value)));
    }
}
