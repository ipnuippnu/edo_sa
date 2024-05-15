<?php

namespace App\Models;

use App\Enums\SchoolLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'jenjang' => SchoolLevel::class
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }
}
