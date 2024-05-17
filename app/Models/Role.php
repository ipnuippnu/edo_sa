<?php

namespace App\Models;

use App\Models\Scopes\ValidUserRoleScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Laratrust\Models\Role as RoleModel;

#[ScopedBy([ValidUserRoleScope::class])]
class Role extends RoleModel
{

    public $guarded = [];

    public function cleanName()
    {
        if($this->is_pending === FALSE) throw new \Exception("Role tidak pending!");

        return preg_replace("/^pending./", '', $this->name);
    }

    public function activateUserRole(User|int $user, Pimpinan|int $pimpinan)
    {
        if(is_int($user)) $user = User::find($user);
        if(is_int($pimpinan)) $pimpinan = Pimpinan::find($pimpinan);

        DB::table('role_user')->whereUserId($user->id)->whereTeamId($pimpinan->id)->whereRoleId($this->id)->update([
            'confirmed_at' => Carbon::now()
        ]);

        return $this;
    }

    public function deactivateUserRole(User|int $user, Pimpinan|int $pimpinan)
    {
        if(is_int($user)) $user = User::find($user);
        if(is_int($pimpinan)) $pimpinan = Pimpinan::find($pimpinan);

        DB::table('role_user')->whereUserId($user->id)->whereTeamId($pimpinan->id)->whereRoleId($this->id)->update([
            'confirmed_at' => null
        ]);

        return $this;
    }

    public function scopeForceUnconfirmed(Builder $builder)
    {
        $builder->withoutGlobalScope(ValidUserRoleScope::class);
    }
}
