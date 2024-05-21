<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pimpinan;
use App\Models\UserJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->get('_type') == 'query') return $this->_q($request);

        else if($request->expectsJson())
            return datatables(Auth::user()->jabatan_pivots()->with('jabatan')->with('pimpinan'))
                    ->only(['id', 'status', 'jabatan.name', 'pimpinan.name', 'created_at'])
                    ->editColumn('status', fn($data) => $data->status->name)
                    ->make(true);
        
        return view('roles');
    }

    private function _q(Request $request) : mixed
    {
        if($request->get('q') != "")
        {
            $result = Jabatan::{strtolower(Auth::user()->banom)}()->whereIsPublic(true)->whereFullText('name', $request->get('q'))->get(['id', 'name as text']);
        }

        else $result = [];
        

        return response()->json([
            'results' => $result
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pimpinan' => 'required|exists:pimpinans,id',
            'jabatan' => 'required_if:pimpinan,exists:jabatans,id',
            'is_pengurus' => 'in:pengurus'
        ]);

        $jabatan = Jabatan::findOrFail($request->jabatan);
        $pimpinan = Pimpinan::findOrFail($request->pimpinan);

        dd($jabatan);

        Auth::user()->addJabatan($request->jabatan, $request->pimpinan);

        Session::flash('message', 'Data berhasil diajukan. Mengunggu persetujuan dari pihak terkait.');
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
    public function destroy(Request $request, string $id)
    {
        $role = UserJabatan::whereUserId(Auth::user()->id)->whereId($id)->firstOrFail();
        $role->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
