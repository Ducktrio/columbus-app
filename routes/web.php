<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ServiceTicketsController;
use App\Http\Controllers\UsersController;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\ServiceTicket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    
    return view('index');
})->name('index');

Route::prefix("auth")->group(function () {

    Route::get('login', function () {       //  login
        return view('auth.login');
    })->name("login");

    Route::post('login', [AuthController::class, "login"])->name("login.submit");               //  login.submit

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

});

Route::prefix('rooms')->group(function () {

    Route::get('/search', [RoomsController::class, 'search'])->name('rooms.search'); // rooms.search
});


/** Managers Route */
Route::prefix('managers')->middleware('role:Manager')->group(function () {

    Route::get("/", function () {
        return redirect()->route('managers.listUsers');
    })->name('managers');       // managers

    Route::prefix('rooms')->group(function () {

        Route::get('/', function (Request $request) {
            $rooms = Room::query();

            if ($request->filled('status')) {
                $rooms->where('status', $request->query('status'));
            }

            if ($request->filled('room_type')) {
                $rooms->where('room_type_id', $request->query('room_type'));
            }



            return view(
                'managers.room.manageRooms',
                ['rooms' => $rooms->get()->all(), 'roomTypes' => RoomType::query()->get()->all()]
            );
        })->name('managers.manageRooms');       //  managers.manageRooms

        Route::get('/detail/{id}', function (Request $request, string $id) {
            $room = Room::find($id);
            $roomTypes = RoomType::query()->get()->all();
            if ($room) {
                return view('managers.room.roomDetail', ['room' => $room, 'roomTypes' => $roomTypes]);
            }
            return redirect()->route('managers.manageRooms')->with('error', 'Room not found');
        })->name('managers.roomDetail');       //  managers.roomDetail

        Route::get('/create', function () {
            $types = RoomType::query()->get()->all();
            return view("managers.room.createRoom", ["roomTypes" => $types]);
        })->name('managers.createRoom');        //  managers.createRoom

        Route::get('/updateStatus/{id}&{status}', [RoomsController::class, 'updateStatus'])->name('managers.updateRoomStatus');        //  managers.updateRoomStatus

        Route::post("/create", [RoomsController::class, "create"])->name('managers.createRoom.submit');

        Route::put('/update/{id}', [RoomsController::class, 'update'])->name('managers.updateRoom');
        Route::delete('/delete/{id}', [RoomsController::class, 'delete'])->name('managers.deleteRoom');
    });

    Route::prefix("users")->group(function () {


        Route::get('list', function () {
            $users = User::query()->get()->all();
            return view('managers.user.listUsers', ["users" => $users]);
        })->name('managers.listUsers');        //  managers.manageUsers


        Route::get("create", function () {
            $roles = Role::query()->get()->all();
            return view('managers.user.createUser', ['roles' => $roles]);
        })->name('managers.createUser');        //  managers.createUser

        Route::post("create", [AuthController::class, 'register'])->name('managers.createUser.submit');        //  managers.createUser

        Route::delete('delete/{id}', [UsersController::class, 'delete'])->name('managers.deleteUser');        //  managers.deleteUser
    });

    Route::prefix('ticket')->group(function () {

        Route::get('list', function (Request $request) {
            $tickets = \App\Models\ServiceTicket::query();
            $status = $request->query('status');

            if ($status === '0') {
                $tickets->where('status', 0);
            } elseif ($status === '1') {
                $tickets->where('status', 1);
            } elseif ($status === '2') {
                $tickets->where('status', 2);
            }
            $tickets = $tickets->paginate(5);

            return view('managers.ticket.listTickets', ["tickets" => $tickets]);
        })->name('managers.listTickets'); // managers.listTickets


        Route::get('create', function (Request $request) {


            $services = \App\Models\Service::query()->get()->all();


            $rooms = Room::query();
            $customers = Customer::query();

            if ($request->has('searchRoom')) {
                $rooms->where('label', 'LIKE', '%' . $request->query('searchRoom') . '%')
                    ->orWhereHas('roomType', function ($q) use ($request) {
                        $q->where('name', 'LIKE', '%' . $request->query('searchRoom') . '%');
                    });
            }

            if ($request->has('searchCustomer')) {
                $customers->where('full_name', 'LIKE', '%' . $request->query('searchCustomer') . '%');
            }

            $rooms = $rooms->paginate(5);
            $customers = $customers->paginate(5);

            if ($request->ajax()) {
                return response()->json([
                    'htmlRooms' => view('managers.partials.roomList', compact('rooms'))->render(),
                    'htmlCustomers' => view('managers.partials.customerList', compact('customers'))->render(),
                ]);
            }
            return view('managers.ticket.createTicket', ['rooms' => $rooms, 'services' => $services, "customers" => $customers]);



        })->name('managers.createTicket'); // managers.createTicket

        Route::post('create', [ServiceTicketsController::class, 'create'])->name('managers.createTicket.submit'); // managers.createTicket.submit


        Route::get('detail/{id}', function (string $id) {
            $ticket = ServiceTicket::find($id);
            if ($ticket) {
                return view('managers.ticket.ticketDetail', ['ticket' => $ticket]);
            }
            return redirect()->route('managers.listTickets')->with('error', 'Ticket not found');
        })->name('managers.ticketDetail'); // managers.ticketDetail

        Route::post('update/{id}', [ServiceTicketsController::class, 'update'])->name('managers.updateTicket'); // managers.updateTicket
        Route::get('/updateStatus/{id}&{status}', [ServiceTicketsController::class, 'updateStatus'])->name('managers.updateTicketStatus');        //  managers.updateTicketStatus
        Route::delete('delete/{id}', [ServiceTicketsController::class, 'delete'])->name('managers.deleteTicket');        //  managers.deleteUser

    });
}); // managers

/** Receiption Route */
Route::prefix('reception')->group(function () {

    Route::get('/', function () {
        $roomCount = count(Room::query()->where('status', 0)->get()->all());
        return view('receptionist.dashboard', ["roomCount" => $roomCount]);
    })->name('reception');          //  receiptionist


})->middleware('role:Receptionist'); // receiptionist


/** Staff Route */
Route::prefix('staff')->group(function () {

    Route::get('/', function () {
        return redirect()->route('staff.dashboard');
    })->name('staff');       // staff

    Route::get('/dashboard', function (string $service_id = null) {
        
        $tickets = ServiceTicket::query();

        if($service_id) {
            $tickets->where('service_id', $service_id);
        }

        $tickets = $tickets->paginate(5)->sortByDesc('created_at');


        return view('staff.dashboard', ["tickets" => $tickets]);
    })->name('staff.dashboard');          //  staff.dashboard

})->middleware('role:Staff');