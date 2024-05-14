<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactVerificationCode extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'valid_until' => 'timestamp'
    ];
}
