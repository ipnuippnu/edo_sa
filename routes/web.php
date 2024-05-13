<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\ContactVerification;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WizardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('L-15-4')->group(function(){

    Route::get('/', HomeController::class)->name('home');

    Route::post('wizard', WizardController::class)->name('wizard');

    Route::post('verify', [ContactVerification::class, 'verify'])->name('verify');
    Route::post('verify/request', [ContactVerification::class, 'request'])->name('verify.request');

});

Route::redirect('/', 'L-15-4');

Route::middleware('guest')->group(function(){
    Route::get('/login', LoginController::class)->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/signup', SignupController::class)->name('signup');
    Route::post('/signup', [SignupController::class, 'signup']);
});
