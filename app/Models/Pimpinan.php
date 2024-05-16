<?php

namespace App\Models;

use App\Models\Traits\Ulids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\Team as LaratrustTeam;

class Pimpinan extends LaratrustTeam
{
    use SoftDeletes, Ulids;
    public $guarded = [];
}
