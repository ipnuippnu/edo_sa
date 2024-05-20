<?php

namespace App\Models;

use App\Enums\WilayahLevel;
use App\Models\Traits\Ulids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Pimpinan extends Model
{
    use SoftDeletes, Ulids;

    protected $guarded = [];

    public function parent() : Attribute
    {
        return Attribute::get(fn() => Wilayah::find(preg_replace("/\.\d+$/", '', $this->address_code)));
    }

    public function display_name() : Attribute
    {
        return Attribute::get(function(){

            if($this->parent->level === WilayahLevel::KECAMATAN) return $this->display_name . ", Kec. " . $this->parent->nama;

            return $this->display_name;

        });
    }
}
