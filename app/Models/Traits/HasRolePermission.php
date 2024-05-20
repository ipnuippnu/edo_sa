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

    public function tambahJabatan(int|Jabatan|string $jabatan, int|Pimpinan $pimpinan, array $attributes = [])
    {
        if(is_numeric($jabatan)) $jabatan = Jabatan::find($jabatan);
        else if(is_string($jabatan)) $jabatan = Jabatan::whereCode($jabatan)->first();

        if(is_numeric($pimpinan)) $pimpinan = Pimpinan::find($pimpinan);
        
        return $this->jabatan_pivots()->create(array_merge([
            'jabatan_id' => $jabatan->id,
            'pimpinan_id' => $pimpinan->id,
            'status' => JabatanStatus::PENDING
        ], $attributes));
    }

}
