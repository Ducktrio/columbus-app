<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\RoomTicketsController;
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

    if (Auth::user()) {
        $user = Auth::user();
        $routes = [
            'Manager' => 'managers',
            'Receptionist' => 'reception',
            'Staff' => 'staff.dashboard',
        ];
        if (array_key_exists($user->role->title, $routes)) {
            return redirect()->route($routes[$user->role->title]);
        }
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
            $roomType = RoomType::query()->get()->first();

            if ($request->filled('status')) {
                $rooms->where('status', $request->query('status'));
            } else {
                return redirect()->route('managers.manageRooms', array_merge($request->query(), ['status' => '0']));
            }

            if ($request->filled('room_type')) {
                $rooms->where('room_type_id', $request->query('room_type'));
            } else {
                return redirect()->route('managers.manageRooms', array_merge($request->query(), ['room_type' => $roomType->id]));
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
            } else {
                return redirect()->route('managers.listTickets', array_merge($request->query(), ['status' => '0']));
            }
            $tickets = $tickets->paginate(6);

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
            $customers = $customers->paginate(4);

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
            $ticket = ServiceTicket::query()->find($id);
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
        $rooms = Room::query()->get()->all();
        $roomTypes = RoomType::query()->get()->all();


        return view('receptionist.dashboard', ["rooms" => $rooms, "roomTypes" => $roomTypes]);
    })->name('reception');          //  receiption

    Route::get('/checkin', function (Request $request) {
        $customers = Customer::query();
        $rooms = Room::query()->where('status', 0);

        if ($request->ajax()) {
            if ($request->has('searchCustomer')) {
                $customers->where('full_name', 'LIKE', '%' . $request->query('searchCustomer') . '%');
            }
            if ($request->has('searchRoom')) {
                $rooms->where('label', 'LIKE', '%' . $request->query('searchRoom') . '%')
                    ->orWhereHas('roomType', function ($q) use ($request) {
                        $q->where('name', 'LIKE', '%' . $request->query('searchRoom') . '%');
                    });
            }

            $customers = $customers->paginate(6);
            $rooms = $rooms->get()->all();

            return response()->json([
                'htmlCustomers' => view('receptionist.partials.customerList', compact('customers'))->render(),
                'htmlRooms' => view('receptionist.partials.roomList', ['rooms' => $rooms, 'roomSelected' => $request->query('room_id')])->render(),
            ]);
        }

        $customers = $customers->paginate(6);
        $rooms = $rooms->get()->all();

        return view('receptionist.checkin', ['customers' => $customers, "rooms" => $rooms]);
    })->name('reception.checkin'); // receiption.checkin

    Route::get("checkIn", [RoomTicketsController::class, 'checkIn'])->name('reception.checkin.checkin'); // receiption.checkin


    Route::post('/checkin', [\App\Http\Controllers\RoomTicketsController::class, 'create'])->name('reception.checkin.submit'); // receiption.checkin.submit


    Route::get('/checks', function (Request $request) {


        $roomTickets = \App\Models\RoomTicket::query()->where('status', '!=', 1);

        if ($request->query('filter') == '0') {
            $roomTickets->whereNull('check_in');
        } else if ($request->query('filter') == '1') {
            $roomTickets->whereNotNull('check_in');
        }

        $roomTickets = $roomTickets->paginate(6);


        return view('receptionist.checks', ['roomTickets' => $roomTickets]);
    })->name('reception.checks'); // receiption.checks

    Route::get('/checks/{id}', function (string $id) {
        $roomTicket = \App\Models\RoomTicket::query()->find($id);
        return view('receptionist.checkDetail', ['roomTicket' => $roomTicket]);
    })->name('reception.checkDetail'); // receiption.checkDetail


    Route::prefix('customer')->group(function () {

        Route::get('/', function () {
            $customers = Customer::query()->paginate(6);
            return view('receptionist.customer.listCustomers', ['customers' => $customers]);
        })->name('reception.customer'); // receiption.customer

        Route::get('register', function (Request $request) {


            return view('receptionist.customer.register')->with('redirect_to', $request->query('redirect_to', 'reception.checkin'));
        })->name('reception.customer.register'); // receiption.customer.register

        Route::post('register', [CustomersController::class, 'create'])->name('reception.customer.register.submit'); // receiption.customer.register.submit

    });
})->middleware('role:Receptionist'); // receiptionist


/** Staff Route */
Route::prefix('staff')->group(function () {

    Route::get('/', function () {
        return redirect()->route('staff.dashboard');
    })->name('staff');       // staff



    Route::get('/dashboard', function (Request $request) {

        $service_id = $request->query('service_id');
        $status = $request->query('status');

        $tickets = ServiceTicket::query();

        if ($service_id) {
            $tickets->where('service_id', $service_id);
        }

        if (isset($status)) {
            $tickets->where('status', $status);
        } else {
            return redirect()->route('staff.dashboard', array_merge($request->query(), ['status' => '0']));
        }

        $tickets = $tickets->orderBy('status')->orderByDesc('created_at')->paginate(6);

        return view('staff.dashboard', ["tickets" => $tickets]);
    })->name('staff.dashboard');          //  staff.dashboard

    Route::get('/ticket/detail/{id}', function (string $id) {
        $ticket = ServiceTicket::find($id);
        if ($ticket) {
            return view('staff.ticketDetail', ['ticket' => $ticket]);
        }
        return redirect()->route('staff.dashboard')->with('error', 'Ticket not found');
    })->name('staff.ticketDetail');          //  staff.ticketDetail


})->middleware('role:Staff');


Route::prefix('ticket')->group(function () {

    Route::get('take/{id}', [ServiceTicketsController::class, 'take'])->name('ticket.take'); // ticket.take
    Route::get('close/{id}', [ServiceTicketsController::class, 'close'])->name('ticket.close'); // ticket.close

})->middleware("role:Staff,Manager,Receiptionist"); // ticket
