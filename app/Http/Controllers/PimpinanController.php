<?php

namespace App\Http\Controllers;

use App\Models\Pimpinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PimpinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->get('q') != "")
        {
            $result = Pimpinan::where(function($query) use($request) {

                $query->whereBanom(Auth::user()->personal->gender === 'P' ? 'IPPNU' : 'IPNU')->whereFullText('name', $request->get('q'));

            })->get()->map(fn($v) => [
                'id' => $v->id,
                'text' => $v->display_name
            ]);
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
        abort(404);
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
    public function destroy(string $id)
    {
        abort(404);
    }
}
