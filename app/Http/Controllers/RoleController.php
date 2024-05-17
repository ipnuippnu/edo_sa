<?php

namespace App\Http\Controllers;

use App\Models\Pimpinan;
use App\Models\Role;
use App\Models\User;
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
            return datatables(Auth::user()->roles()->forceUnconfirmed())
                    ->addColumn('team_name', function($q){
                        return Pimpinan::find($q->team_id, 'name')->name;
                    })
                    ->only(['id', 'display_name', 'team_id', 'team_name', 'confirmed_at', 'created_at'])
                    ->make(true);
        
        return view('roles');
    }

    private function _q(Request $request) : mixed
    {
        if($request->get('q') != "")
        {
            $result = Role::where(function($q){

                $q->where('banom_only', Auth::user()->personal->gender === 'P' ? 'IPPNU' : 'IPNU')->orWhereNull('banom_only');
                
            })->whereFullText('display_name', $request->get('q'))->get(['id', 'display_name as text']);

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
            'jabatan' => 'required|exists:roles,id',
            'pimpinan' => 'required|exists:pimpinans,id'
        ]);

        Auth::user()->syncRoles([$request->jabatan], $request->pimpinan);

        Session::flash('message', 'Data berhasil disimpan');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
