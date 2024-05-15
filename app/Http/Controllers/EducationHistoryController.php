<?php

namespace App\Http\Controllers;

use App\Enums\SchoolLevel;
use App\Models\EducationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class EducationHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->expectsJson())
            return datatables(Auth::user()->education_histories)
                    ->addIndexColumn()
                    ->only(['id', 'name', 'jenjang', 'jurusan', 'graduated_at'])
                    ->editColumn('jenjang', fn(EducationHistory $data) => $data->jenjang->name)
                    ->make(true);

        return view('educations');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenjang' => ['required', Rule::enum(SchoolLevel::class)],
            'name' => ['required', 'ascii'],
            'graduated_at' => ['required', 'date_format:Y'],
            'jurusan' => [Rule::requiredIf(!in_array($request->jenjang, [SchoolLevel::SD->value, SchoolLevel::SLTP->value, SchoolLevel::SLTA->value]))]
        ]);

        Auth::user()->education_histories()->create($request->only('jenjang', 'name', 'graduated_at', 'jurusan'));

        Session::flash('message', 'Data Berhasil Disimpan!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EducationHistory $education_history)
    {
        $education_history->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
