<?php

namespace App\Models\Traits;

trait Ulids
{
    protected static function bootUlids()
    {
        static::creating(function ($model){
            if (empty($model->ulid)) {
                $model->ulid = \Str::ulid();
        
                if ($model->consecutive) {
                    $model->consecutive = $model->max("consecutive") + 1;
                }
            }
        });
    }
}