<?php

namespace App\Providers;

use App\Models\PersonalInformation;
use App\Models\User;
use App\Policies\PersonalInformationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PerizinanProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //!!! SUPERUSER
        // Gate::before(function(User $user){
        //     if($user->email === 'isnunas@gmail.com') return true;
        // });

        $this->_database();
    }
    
    private function _database()
    {
        
    }
}
