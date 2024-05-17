<?php

namespace App\Models;

use App\Models\Scopes\ValidUserRoleScope;
use App\Models\Traits\Ulids;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laratrust\Models\Team;


#[ScopedBy([ValidUserRoleScope::class])]
class Pimpinan extends Team
{
    use SoftDeletes, Ulids;

    public $is_update_from_system = false;
    protected $guarded = ['name'];

    protected $fillable = [
        'ulid',
        'display_name',
        'description',
        'banom',
        'level',
        'address_code',
        'picture',
        'updated_at',
        'created_at'
    ];

    public function scopeForceUnconfirmed(Builder $builder)
    {
        $builder->withoutGlobalScope(ValidUserRoleScope::class);
    }

    protected static function booted(): void
    {
        static::creating(function(Pimpinan $query){
            $query->name = static::generateNameCodeFromDisplayName($query->display_name, $query->address_code);
        });

        static::updating(function(Pimpinan $query){
            $query->name = static::generateNameCodeFromDisplayName($query->display_name, $query->address_code);
        });
    }

    public static function generateNameCode(string $banom, string $level, string $address_code, string $wilayah_instansi) : string
    {
        return strtolower(implode('.', [$banom, $level, str_replace('.', '', $address_code), $wilayah_instansi]));
    }

    public static function generateNameCodeFromDisplayName(string $display_name, string $address_code)
    {
        preg_match("/^(?P<level>PC|PAC|PK|PR) (?P<banom>IPNU|IPPNU) (?P<nama>.*)$/", $display_name, $matchs);
        return self::generateNameCode($matchs['banom'], $matchs['level'], $address_code, Str::slug($matchs['nama'], '_'));
    }
}
