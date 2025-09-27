<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

//    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
//    Volt::route('settings/password', 'settings.password')->name('password.edit');
//    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
//
//    Volt::route('settings/two-factor', 'settings.two-factor')
//        ->middleware(
//            when(
//                Features::canManageTwoFactorAuthentication()
//                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
//                ['password.confirm'],
//                [],
//            ),
//        )
//        ->name('two-factor.show');
});

//require __DIR__.'/auth.php';   //new authentication views. Disabled to use Jetstream based ones

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
