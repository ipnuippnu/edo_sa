<?php

namespace App\Providers;

use App\Models\Pimpinan;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function(Request $request){
            return Limit::perMinute(60)->by($request->ip());
        });

        Blade::directive('personal', function(){
            return "<?php if(auth()->user()->account_type == 1): ?>";
        });

        Blade::directive('endpersonal', function(){
            return "<?php endif; ?>";
        });
    }
}
