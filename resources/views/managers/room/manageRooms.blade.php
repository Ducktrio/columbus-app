@extends('managers.base')


@section('outlet')

    <div class="container d-flex flex-column gap-4">

        <div class="row mb-2">

            <h1 class="mb-5">Manage Rooms</h1>


            <ul class="nav nav-pills nav-fill mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === '0' ? 'active' : '' }}"
                        href="{{ route('managers.manageRooms', array_merge(request()->query(), ['status' => '0'])) }}">
                        Available
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === '1' ? 'active' : '' }}"
                        href="{{ route('managers.manageRooms', array_merge(request()->query(), ['status' => '1'])) }}">
                        Occupied
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === '2' ? 'active' : '' }}"
                        href="{{ route('managers.manageRooms', array_merge(request()->query(), ['status' => '2'])) }}">
                        Unavailable
                    </a>
                </li>


            </ul>




        </div>
        <div class="row mb-2">




            <div class="nav nav-pills nav-fill" role="group" aria-label="Basic mixed styles example">



                @foreach ($roomTypes as $type)


                    <a class="nav-link {{ request('room_type') == $type->id ? 'active' : '' }}"
                        href="{{ route('managers.manageRooms', array_merge(request()->query(), ['room_type' => $type->id])) }}">
                        {{ $type->name }}
                    </a>


                @endforeach

            </div>




        </div>
        <hr>


        <div class="row row-cols-3 g-2">

            @if(count($rooms) == 0)
                <h4>No Room</h4>
            @endif

            @foreach ($rooms as $room)

                <div class="col">

                    @include('components.room', ['room' => $room, 'target' => 'managers.roomDetail'])

                </div>

            @endforeach


        </div>

    </div>


@endsection