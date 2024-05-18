<?php

use App\Models\Pimpinan;

if(!function_exists('currentActiveTeam'))
{
    function currentTeam()
    {
        return session('team_id');
    }
}

if(!function_exists('setActiveTeam'))
{
    function setActiveTeam($team_id) : void
    {
        Pimpinan::firstOrFail($team_id);
        session('team_id', $team_id);
    }
}