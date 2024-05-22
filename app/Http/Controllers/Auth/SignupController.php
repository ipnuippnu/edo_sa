<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PersonalInformation;
use App\Models\User;
use App\Rules\NiceNameRule;
use App\Rules\PhoneNumberRule;
use Brick\PhoneNumber\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class SignupController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'fullname' => ['required', new NiceNameRule()],
            'gender' => ['required', 'in:L,P'],
            'phone' => ['required_without:email', new PhoneNumberRule()],
            'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
            'agree' => ['required'],
            'email' => ['required_without:phone', 'unique:users']
        ], [
            'password.regex' => 'Kolom :attribute harus mengandung:<br> <b>1. Huruf Kecil<br> 2. Huruf Besar<br> 3. Angka</b>'
            ]);

        if($request->has('phone'))
            $phone = $this->_validateExistingPhone($request->get('phone'));
        
        /**
         * RATELIMITER ini difungsikan untuk melakukan pembatasan pendaftaran saja.
         */
        $this->_rateLimiter();

        DB::beginTransaction();

        $data = [
            'name' => $request->get('fullname'),
            'password' => bcrypt($request->get('password')),
        ];

        if($request->has('email'))
            $data['email'] = $request->get('email');

        $personal = [
            'gender' => $request->get('gender'),
        ];

        if(isset($phone))
            $personal['phone'] = $phone;

        
        $user = User::create($data);

        $user->personal()->create($personal);

        DB::commit();
        
        Session::flash('auth', "Pendaftaran berhasil. Silahkan masuk dengan nomor whatsapp / email anda.");

        return redirect()->route('login');
        
    }

    private function _validateExistingPhone($phone)
    {
        $phone = substr(PhoneNumber::parse($phone, 'ID'), 1);

        if(PersonalInformation::wherePhone( $phone )->exists())
            throw ValidationException::withMessages([
                'phone' => 'Nomor telepon telah didaftarkan. Jika ini milik anda, <a target="_blank" href="//wa.me/'.config('app.admin.phone').'">Hubungi '.config('app.admin.name').'</a>.'
            ]);

        return $phone;
    }

    private function _rateLimiter()
    {
        if(RateLimiter::tooManyAttempts('login', 3) && App::environment('production'))
        {
            throw ValidationException::withMessages([
                'attempt' => 'Percobaan masuk pada perangkat ini diblokir selama 60 detik'
            ]);
        }

        RateLimiter::hit('login');
    }
}
