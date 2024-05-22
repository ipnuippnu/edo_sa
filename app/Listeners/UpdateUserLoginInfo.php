<?php

namespace App\Listeners;

use App\Events\Login;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserLoginInfo
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        if($event->user->first_login_at === null)
        {
            $event->user->first_login_at = Carbon::now();
        }

        $event->user->last_login_at = Carbon::now();
        $event->user->timestamps = false;
        $event->user->save();
    }
}
