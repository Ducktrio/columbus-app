<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\UsersController;
use App\Models\Role;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(Auth::user()) {
        $user = Auth::user();
        $routes = [
            'Receptionist' => 'reception',
            'Manager' => 'managers',
            'Staff' => 'staff'
        ];

        return redirect()->route($routes[$user->role->title]);

    }
    return view('index');
})->name('index');

Route::prefix("auth")->group(function () {

    Route::get('login', function () {       //  login
        return view('auth.login');
    })->name("login");

    Route::post('login', [AuthController::class, "login"])->name("login.submit");               //  login.submit

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

});

Route::prefix('managers')->group(function () {

    Route::get("/", function () {
        return redirect()->route('managers.listUsers');
    })->name('managers');       // managers

    Route::prefix('rooms')->group(function() {

        Route::get('/', function(Request $request) {
            $rooms = Room::query();
  
            if($request::filled('status')) {
                $rooms->where('status', $request::query('status'));
            }   

            if($request::filled('room_type')) {
                $rooms->where('room_type_id', $request::query('room_type'));
            }



            return view('managers.room.manageRooms',
                            ['rooms' => $rooms->get()->all(), 'roomTypes' => RoomType::query()->get()->all()]  
                        );
        })->name('managers.manageRooms');       //  managers.manageRooms

        Route::get('/detail/{id}', function(Request $request, string $id) {
            $room = Room::find($id);
            $roomTypes = RoomType::query()->get()->all();
            if ($room) {
                return view('managers.room.roomDetail', ['room' => $room, 'roomTypes' => $roomTypes]);
            }
            return redirect()->route('managers.manageRooms')->with('error', 'Room not found');
        })->name('managers.roomDetail');       //  managers.roomDetail

        Route::get('/create', function() {
            $types = RoomType::query()->get()->all();
            return view("managers.room.createRoom", ["roomTypes" => $types]);
        })->name('managers.createRoom');        //  managers.createRoom

        Route::get('/updateStatus/{id}&{status}', [RoomsController::class, 'updateStatus'])->name('managers.updateRoomStatus');        //  managers.updateRoomStatus

        Route::post("/create", [RoomsController::class, "create"])->name('managers.createRoom.submit');

        Route::put('/update/{id}', [RoomsController::class, 'update'])->name('managers.updateRoom');
        Route::delete('/delete/{id}', [RoomsController::class, 'delete'])->name('managers.deleteRoom');
    });
    
    Route::prefix("users")->group(function() {
        
        
        Route::get('list', function () {
            $users = User::query()->get()->all();
            return view('managers.user.listUsers', ["users" => $users]);
        })->name('managers.listUsers');        //  managers.manageUsers
    
        
        Route::get("create", function() {
            $roles = Role::query()->get()->all();
            return view('managers.user.createUser', ['roles' => $roles]);
        })->name('managers.createUser');        //  managers.createUser

        Route::post("create", [AuthController::class, 'register'])->name('managers.createUser.submit');        //  managers.createUser

        Route::delete('delete/{id}', [UsersController::class, 'delete'])->name('managers.deleteUser');        //  managers.deleteUser
    });
});


Route::prefix('reception')->group(function() {

    Route::get('/', function() {
        $roomCount = count(Room::query()->where('status', 0)->get()->all());
        return view('receptionist.dashboard', ["roomCount" => $roomCount]);
    })->name('reception');          //  receiptionist


})->middleware('auth.basic');


Route::prefix('rooms')->group(function() {

});