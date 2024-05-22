<?php

namespace App\Http\Controllers;

use App\Http\Middleware\WizardMiddleware;
use App\Models\Wilayah;
use App\Rules\NiceNameRule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class WizardController extends Controller
{
    public function __invoke()
    {
        return view('wizard');
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => ['required', new NiceNameRule],
            'gender' => ['required', 'in:L,P'],
            'born_place' => ['required'],
            'born_date' => 'required|date',
            'joined_year' => 'required|digits:4',
            'profile' => [Rule::requiredIf(auth()->user()->picture == null), 'image'],
            'alamat' => 'required|exists:wilayah,kode|regex:' . Wilayah::REGEX,
            'rt' => 'required|numeric|min:1|max_digits:3',
            'rw' => 'required|numeric|min:1|max_digits:3',
            'dusun' => 'required'
        ]);

        if(is_null(auth()->user()->email_verified_at) && is_null(auth()->user()->personal->phone_verified_at))
            throw ValidationException::withMessages(['name' => 'Anda harus melakukan verifikasi email/whatsapp terlebih dahulu']);

        auth()->user()->update(array_filter([
            'name' => $request->get('name'),
            'picture' => $request->hasFile('profile') ? $request->file('profile')->storeAs('', Str::slug(auth()->user()->id .'-'. auth()->user()->name) . '.' .  $request->file('profile')->extension(), ['disk' => 'profile']) : null,
        ]));
        
        auth()->user()->personal->update([
            'gender' => $request->gender,
            'born_place' => $request->born_place,
            'born_date' => $request->born_date,
            'joined_at' => $request->joined_year,
            'finished_at' => Carbon::now(),
            'wilayah_kode' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'dusun' => $request->dusun,
        ]);

        Session::flash('message', 'Data berhasil disimpan!');

        return redirect()->route('home');
    }
}
