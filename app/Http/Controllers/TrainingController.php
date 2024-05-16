<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->get('_type') == 'query') return $this->_q($request);

        elseif($request->expectsJson()) return datatables(Auth::user()->trainings())
                                            ->addColumn('is_mine', fn(Training $training) => Auth::user()->id == $training->creator_id)
                                            ->only(['id', 'is_formal', 'is_mine', 'name', 'pelaksana', 'year'])
                                            ->make(true);

        return view('trainings');
    }

    private function _q(Request $request) : mixed
    {
        if($request->get('q') != "")
        {
            $result = Training::whereFullText(['name', 'pelaksana', 'year'], $request->get('q'))->get()->map(function(Training $training){
                return [
                    'id' => $training->id,
                    'text' => "$training->year | $training->name | $training->pelaksana"
                ];
            })->toArray();
            
            if(count($result) == 0)
            {
                $result = [
                    ['id' => "_null", 'text' => 'Tidak ditemukan. Klik disini untuk membuat baru...']
                ];
            }
            else
            {
                $result[] = [
                    'id'    => '_null',
                    'text'  => 'Klik disini untuk membuat baru...'
                ];
            }
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
        if($request->get('pengkaderan') === "_null")
            $this->_notExist($request);

        else $this->_exists($request);

        Session::flash('message', 'Data berhasil disimpan');
        return redirect()->back();
    }

    private function _notExist(Request $request)
    {

        $request->validate([
            'year' => 'required|date_format:Y',
            'pelaksana' => 'required',
            'jenjang' => 'required_if:jenis,formal|exists:formal_training_levels,name',
            'nama' => 'required_if:jenis,non-formal',
            'jenis' => 'required|in:formal,non-formal'
        ]);

        $training = Training::firstOrCreate([
            'year' => $request->get('year'),
            'pelaksana' => $request->get('pelaksana'),
            'name' => $request->get('nama') ?? $request->get('jenjang'),
            'is_formal' => $request->get('jenis') === 'formal',
            'creator_id' => Auth::user()->id
        ]);

        Auth::user()->trainings()->syncWithoutDetaching($training);

    }

    private function _exists(Request $request)
    {
        $request->validate([
            'pengkaderan' => 'required|exists:trainings,id'
        ]);

        Auth::user()->trainings()->syncWithoutDetaching($request->only('pengkaderan'));
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
        $training = Auth::user()->trainings()->whereId($id)->firstOrFail();
        Auth::user()->trainings()->detach($id);

        //!!! HAPUS JIKA TIDAK ADA USERNYA
        if($training->creator_id == Auth::user()->id && !$training->users()->exists())
            $training->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
