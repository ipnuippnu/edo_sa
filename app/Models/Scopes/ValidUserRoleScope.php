<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ValidUserRoleScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(is_array($builder->getQuery()->joins))
        {
            foreach($builder->getQuery()->joins as $join)
            {
                if($join->table === 'role_user')
                {
                    $builder->whereNotNull('role_user.confirmed_at');
                    break;
                }
            }
        }
    }
}
