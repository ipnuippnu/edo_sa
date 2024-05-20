<?php

namespace App\Models;

use App\Enums\JabatanStatus;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserJabatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public $casts = [
        'status' => JabatanStatus::class
    ];

    public function jabatan() : BelongsTo
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pimpinan() : BelongsTo
    {
        return $this->belongsTo(Pimpinan::class);
    }
    
}
