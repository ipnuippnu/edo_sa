<?php

namespace App;

use Brick\PhoneNumber\PhoneNumber;
use Illuminate\Support\Facades\Http;

trait SendWhatsappMessage
{
    public static function send(PhoneNumber $phoneNumber, string $message, string|null $img_blob = null)
    {
        $request = new Http;

        if(!is_null($img_blob))
            $request->attach('img', $img_blob);
        
        $request->post(config('app.wabot_url') . '/send', [
            'phone' => substr($phoneNumber, 1) . "@c.us",
            'message' => $message,
        ]);

        $request->throw();

        return true;
    }
}
