<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\ContactVerificationController;
use App\Http\Controllers\EducationHistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WizardController;
use App\Http\Middleware\WizardMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', WizardMiddleware::class])->prefix('L-155-4')->group(function(){

    Route::get('/', HomeController::class)->name('home');

    Route::middleware('personal')->group(function(){
        Route::get('wizard', WizardController::class)->name('wizard');
        Route::post('wizard', [WizardController::class, 'save'])->name('wizard.save');

        Route::post('verify', [ContactVerificationController::class, 'verify'])->name('verify');
        Route::post('verify/request', [ContactVerificationController::class, 'request'])->name('verify.request');

        Route::apiResource('education_histories', EducationHistoryController::class)->name('index', 'educations');
        Route::apiResource('trainings', TrainingController::class)->name('index', 'trainings');
        Route::apiResource('roles', RoleController::class)->name('index', 'roles');
        Route::apiResource('pimpinans', PimpinanController::class)->name('index', 'pimpinans');
    });

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::redirect('/', 'L-155-4');

Route::middleware('guest')->group(function(){
    Route::get('/login', LoginController::class)->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/signup', SignupController::class)->name('signup');
    Route::post('/signup', [SignupController::class, 'signup']);
});