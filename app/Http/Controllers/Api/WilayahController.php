<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Cache;

class WilayahController extends Controller
{
    public function provinsi()
    {
        return response()->json([
            'status' => true,
            'data' => Wilayah::provinsi()->get()
        ]);
    }

    public function kab_kota($wilayah)
    {
        return response()->json([
            'status' => true,
            'data' => Wilayah::kabKota()->where('kode', 'LIKE', "$wilayah%")->get()
        ]);
    }

    public function kecamatan($wilayah)
    {
        return response()->json([
            'status' => true,
            'data' => Wilayah::kecamatan()->where('kode', 'LIKE', "$wilayah%")->get()
        ]);
    }

    public function desa($wilayah)
    {
        return response()->json([
            'status' => true,
            'data' => Wilayah::desa()->where('kode', 'LIKE', "$wilayah%")->get()
        ]);
    }

    public function lokal()
    {
        return response()->json([
            'status' => true,
            'results' => Cache::remember('address:lokal', 60 * 30, function(){
                return Wilayah::kecamatan()->where('kode', 'LIKE', '35.03%')->get()->map(function(Wilayah $kec){
                    return [
                        'text' => "Kecamatan $kec->nama",
                        'children' => Wilayah::desa()->where('kode', 'LIKE', "$kec->kode%")->get()->map(function(Wilayah $wilayah) use($kec) {
                            return [
                                'id' => $wilayah->kode,
                                'text' => "(Kec. $kec->nama) Desa $wilayah->nama",
                            ];
                        })
                    ];
                });
            })
        ]);
    }
}
