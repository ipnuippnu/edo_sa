<?php

use App\Http\Controllers\Api\WilayahController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'api.'], function(){

    Route::get('/wilayah/desa/{wilayah}', [WilayahController::class, 'desa'])->where('wilayah', '\w{2}\.\w{2}\.\w{2}');
    Route::get('/wilayah/kecamatan/{wilayah}', [WilayahController::class, 'kecamatan'])->where('wilayah', '\w{2}\.\w{2}');
    Route::get('/wilayah/kab_kota/{wilayah}', [WilayahController::class, 'kab_kota'])->where('wilayah', '\w{2}');
    Route::get('/wilayah/provinsi', [WilayahController::class, 'provinsi']);

    Route::get('/wilayah/lokal', [WilayahController::class, 'lokal'])->name('wilayah.lokal');
});