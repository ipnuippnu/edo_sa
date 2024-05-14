<?php

namespace App\Http\Controllers;

use App\Events\EmailCodeRequested;
use App\Events\WhatsappCodeRequested;
use App\Models\ContactVerificationCode;
use App\Models\PersonalInformation;
use App\Models\User;
use App\Rules\PhoneNumberRule;
use Brick\PhoneNumber\PhoneNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ContactVerification extends Controller
{
    public function request(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email,whatsapp',
            'contact' => ['required', Rule::when(fn($input) => $input['type'] == 'whatsapp', new PhoneNumberRule, 'email')]
        ]);
        
        //TIDAK ADA DUPLIKASI NOMOR TELEPON / EMAIL
        if( $request->get('type') == 'whatsapp' ){
            $number = PhoneNumber::parse($request->get('contact'), 'ID');
            $personal = PersonalInformation::wherePhone($number)->whereNotNull('phone_verified_at')->first();
            if($personal && $personal->user->id != auth()->user()->id)
                throw ValidationException::withMessages(['contact' => 'Nomor telepon sudah digunakan pengguna lain']);
        }

        else if( $request->get('type') == 'email' ){
            $user = User::whereEmail($request->get('contact'))->whereNotNull('email_verified_at')->first();
            if($user && $user->id != auth()->user()->id)
                throw ValidationException::withMessages(['contact' => 'Email sudah digunakan pengguna lain']);
        }

        $this->{"_" . $request->get('type')}($request, $number ?? $request->get('contact'));

        return response()->json([
            'status' => true
        ]);

    }

    private function _whatsapp(Request $request, PhoneNumber $phone)
    {
        WhatsappCodeRequested::dispatch($phone);
    }

    private function _email(Request $request, $email)
    {
        EmailCodeRequested::dispatch($email);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'type' => 'required|in:whatsapp,email',
            'contact' => ['required', Rule::when(fn($input) => $input['type'] == 'whatsapp', new PhoneNumberRule, 'email')],
            'code' => 'required|digits:5'
        ]);

        if($request->get('type') == 'whatsapp') $number = PhoneNumber::parse($request->get('contact'), 'ID');
        
        $code = ContactVerificationCode::whereContact($number ?? $request->get('contact'))
                ->whereType($request->get('type'))
                ->whereCode($request->get('code'))
                ->where('valid_until', '>=', Carbon::now())
                ->first();

        if(!$code) throw ValidationException::withMessages(['code' => 'Kode tidak valid/sudah kadaluarsa']);

        //SUKSES
        if( $request->get('type') == 'whatsapp' )
        {
            auth()->user()->personal->update([
                'phone' => $code->contact,
                'phone_verified_at' => Carbon::now()
            ]);
        }

        if( $request->get('type') == 'email' )
        {
            auth()->user()->update([
                'email' => $code->contact,
                'email_verified_at' => Carbon::now()
            ]);
        }

        $code->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diverifikasi',
            'data' => [
                'contact' => $code->contact
            ]
        ]);

    }
}
