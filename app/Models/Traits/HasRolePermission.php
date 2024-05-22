<?php

namespace App\Models\Traits;

use App\Enums\JabatanStatus;
use App\Models\Jabatan;
use App\Models\Pimpinan;
use App\Models\UserJabatan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

trait HasRolePermission
{
    public function jabatan_pivots() : HasMany
    {
        return $this->hasMany(UserJabatan::class);
    }

    public function jabatans(?JabatanStatus $status = null) : HasManyThrough
    {
        $query = $this->hasManyThrough(
            related: Jabatan::class,
            through: UserJabatan::class,
            firstKey: 'user_id',
            secondKey: 'id',
            localKey: 'id',
            secondLocalKey: 'jabatan_id'
        );

        if($status !== null)
        {
            $query->where('jabatans.status', $status);
        }

        return $query;
    }

    public function addJabatan(int|Jabatan|string $jabatan, int|Pimpinan $pimpinan, array $attributes = [])
    {
        if($jabatan instanceof Jabatan) $jabatan = $jabatan->id;
        elseif(is_numeric($jabatan)) $jabatan = (int) $jabatan;
        else if(is_string($jabatan)) $jabatan = Jabatan::whereCode($jabatan)->first()->id;

        if($pimpinan instanceof Pimpinan) $pimpinan = $pimpinan->id;
        elseif(is_numeric($pimpinan)) $pimpinan = (int) $pimpinan;
        
        return $this->jabatan_pivots()->create(array_merge([
            'jabatan_id' => $jabatan,
            'pimpinan_id' => $pimpinan,
            'status' => JabatanStatus::PENDING
        ], $attributes));
    }

    public function hasActiveJabatan(int|Jabatan|string $jabatan, int|Pimpinan $pimpinan, array $attributes = []) : bool
    {
        if($jabatan instanceof Jabatan) $jabatan = Jabatan::find($jabatan)->id;
        elseif(is_numeric($jabatan)) $jabatan = (int) $jabatan;
        else if(is_string($jabatan)) $jabatan = Jabatan::whereCode($jabatan)->first()->id;

        if($pimpinan instanceof Pimpinan) $pimpinan = $pimpinan->id;
        elseif(is_numeric($pimpinan)) $pimpinan = (int) $pimpinan;

        return $this->jabatans(JabatanStatus::AKTIF)->whereJabatanId($jabatan)->wherePimpinanId($pimpinan)->exists();

    }

}
