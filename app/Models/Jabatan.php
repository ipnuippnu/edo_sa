<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function scopeIpnu(Builder $builder)
    {
        return $builder->whereBanomOnly('IPNU')->orWhereNull('banom_only');
    }

    public function scopeIppnu(Builder $builder)
    {
        return $builder->whereBanomOnly('IPPNU')->orWhereNull('banom_only');
    }
}
