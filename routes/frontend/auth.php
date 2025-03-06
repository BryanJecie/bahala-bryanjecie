<?php

use App\Domains\Auth\Http\Controllers\Frontend\Auth\ConfirmPasswordController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\DisableTwoFactorAuthenticationController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\LoginController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\PasswordExpiredController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\RegisterController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\ResetPasswordController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\SocialController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\TwoFactorAuthenticationController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\UpdatePasswordController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\VerificationController;
use Tabuna\Breadcrumbs\Trail;

/*
 * Frontend Access Controllers
 * All route names are prefixed with 'frontend.auth'.
 */

Route::group(['as' => 'auth.'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => 'guest'], function () {
        Route::redirect('/backend', '/backend/login', 301);
        Route::group(['prefix' => 'backend'], function () {
            // Authentication
            Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
            Route::post('login', [LoginController::class, 'login']);

            // Registration
            Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
            Route::post('register', [RegisterController::class, 'register']);
        });
    });
});
