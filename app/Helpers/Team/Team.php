<?php

namespace App\Helpers\Team;

use App\Models\UserJabatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Team
{
    const SESSION_KEY = 'jabatan_aktif';

    private ?UserJabatan $team_aktif;

    public function __construct($auth)
    {
        dd($auth);
    }

    // public function update()
    // {
    //     $team_aktif = Auth::user()->jabatan_pivots()->whereId(Session::get(self::SESSION_KEY))->first();
    // }
    
    public function setActiveTeam(int|UserJabatan $jabatan) : bool
    {
        if(is_numeric($jabatan)) $jabatan = UserJabatan::find($jabatan);
        
        if(is_null($jabatan) || $result = Auth::user()->jabatan_pivots()->whereId($jabatan->id)->first())
        {
            Session::put(self::SESSION_KEY, $result->id);
            // $this->update();
        }

        return false;
    }

    public function getActiveTeam()
    {
        return $this->team_aktif;
    }
}