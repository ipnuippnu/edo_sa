<?php

namespace App\Models;

use App\Models\Traits\Ulids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pimpinan extends Model
{
    use HasFactory, SoftDeletes, Ulids;

    protected $guarded = ['id'];
}
