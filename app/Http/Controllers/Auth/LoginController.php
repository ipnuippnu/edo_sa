<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PersonalInformation;
use App\Models\User;
use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberParseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->_rateLimiter();

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        extract($request->only('username', 'password'));

        if(filter_var($username, FILTER_VALIDATE_EMAIL)) $this->_usingEmail($username, $password, $request->has('remember'));

        else $this->_usingPhone($username, $password, $request->has('remember'));

        $request->session()->regenerate();
        return redirect()->route('home');
        
    }

    private function _usingPhone($phone, $pass, $remember)
    {
        try {
            $number = PhoneNumber::parse($phone, 'ID');

            if($personal = PersonalInformation::wherePhone(substr((string) $number, 1))->first() )
            {
                $user = $personal->user;
                if(Hash::check($pass, $user->password))
                {
                    return Auth::loginUsingId($user->id);
                }
            }

        }
        catch (PhoneNumberParseException $e) {

        }

        $this->_invalid();
    }

    private function _usingEmail($email, $pass, $remember)
    {
        if($user = User::whereEmail($email)->first())
        {
            if(Auth::attempt(['email' => $email, 'password' => $pass], $remember)) return;
        }

        $this->_invalid();
    }

    private function _invalid()
    {
        throw ValidationException::withMessages([
            'attempt' => 'Informasi yang diberikan tidak valid'
        ]);
    }

    private function _rateLimiter()
    {
        if(RateLimiter::tooManyAttempts('login', 5) && App::environment('production'))
        {
            throw ValidationException::withMessages([
                'attempt' => 'Percobaan masuk pada perangkat ini diblokir selama 2 menit'
            ]);
        }

        RateLimiter::hit('login', 120);
    }
}
