<?php

namespace App\Http\Controllers;

use App\Events\WhatsappCodeRequested;
use App\Rules\PhoneNumberRule;
use Brick\PhoneNumber\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactVerification extends Controller
{
    public function request(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email,whatsapp',
            'contact' => ['required', Rule::when(fn($input) => $input['type'] == 'whatsapp', new PhoneNumberRule, 'email')]
        ]);

        $this->{"_" . $request->get('type')}($request, $request->get('contact'));

        return response()->json([
            'status' => true
        ]);

    }

    private function _whatsapp(Request $request, $phone)
    {
        WhatsappCodeRequested::dispatch(PhoneNumber::parse($phone, 'ID'));
    }

    private function _email(Request $request, $email)
    {

    }
}
