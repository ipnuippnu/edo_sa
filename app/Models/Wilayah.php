<?php

namespace App\Models;

use App\Enums\WilayahLevel;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'kode';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'wilayah';

    const REGEX = "/\w{2}\.\w{2}.\w{2}.\w{4}/";

    public function level() : Attribute
    {
        return new Attribute(
            get: fn() => match(strlen($this->kode)){
                2 => WilayahLevel::PROV,
                5 => WilayahLevel::KAB_KOTA,
                8 => WilayahLevel::KECAMATAN,
                13 => WilayahLevel::DESA
            }
        );
    }

    public function scopeProvinsi(Builder $query): void
    {
        $query->whereRaw('LENGTH(kode) = 2');
    }

    public function scopeKabKota(Builder $query): void
    {
        $query->whereRaw('LENGTH(kode) = 5');
    }

    public function scopeKecamatan(Builder $query): void
    {
        $query->whereRaw('LENGTH(kode) = 8');
    }

    public function scopeDesa(Builder $query): void
    {
        $query->whereRaw('LENGTH(kode) = 13');
    }
    
}
