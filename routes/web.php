<?php

use App\Models\Role;
use App\Models\User;
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

Route::prefix('managers')->group(function () {


    
    Route::prefix("users")->group(function() {
        
        
        Route::get('list', function () {
            $users = User::query()->get()->all();
            return view('managers.listUsers', ["users" => $users]);
        })->name('managers.listUsers');        //  managers.manageUsers
    
        
        Route::get("create", function() {
            $roles = Role::query()->get()->all();
            return view('managers.createUser', ['roles' => $roles]);
        })->name('managers.createUser');        //  managers.createUser

        Route::post("create", function(Request $req) {
            return redirect()->route('managers.listUsers')->with("success", "This is a test");
        })->name('managers.createUser.submit');        //  managers.createUser
    });
});
