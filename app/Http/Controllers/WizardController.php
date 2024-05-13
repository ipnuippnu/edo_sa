<?php

namespace App\Http\Controllers;

use App\Rules\NiceNameRule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WizardController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', new NiceNameRule],
            'gender' => ['required', 'in:L,P'],
            'born_place' => ['required'],
            'born_date' => 'required|date',
            'joined_year' => 'required|digits:4',
            'profile' => 'required|image'
        ]);

        if(is_null(auth()->user()->email_verified_at) && is_null(auth()->user()->personal->phone_verified_at))
            throw ValidationException::withMessages(['name' => 'Anda harus melakukan verifikasi email/whatsapp terlebih dahulu']);

        auth()->user()->update(array_merge($request->only('name')));
        auth()->user()->personal->update([
            'gender' => $request->gender,
            'born_place' => $request->born_place,
            'born_date' => $request->born_date,
            'joined_at' => $request->joined_year,
            'picture' => $request->file('profile')->store('', ['disk' => 'profile']),
            'finished_at' => Carbon::now()
        ]);

        return redirect()->route('home');
    }
}
