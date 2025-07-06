<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route("login");
});

Route::prefix("auth")->group(function () {

    Route::get('login', function () {       //  login
        return view('auth.login');
    })->name("login");

    Route::post('login', function () {
        return back()->with('status', 'Logged in');
    })->name("login.submit");               //  login.submit
});
