<?php

namespace App\Helpers\Team\Facades;

use Clockwork\Support\Laravel\Facade;

class Team extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'team';
    }
}