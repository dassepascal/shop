<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

Volt::route('/', 'index')->name('home');
Volt::route('/pages/{page:slug}', 'page')->name('pages');

Route::middleware('guest')->group(function () {
	Volt::route('/register', 'auth.register');
	Volt::route('/login', 'auth.login')->name('login');
	Volt::route('/forgot-password', 'auth.forgot-password');
	Volt::route('/reset-password/{token}', 'auth.reset-password')->name('password.reset');
});


Route::prefix('account')->group(function () {
	Volt::route('/profile', 'account.profile')->name('profile');
});
