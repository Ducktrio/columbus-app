@extends('managers.base')


@section('outlet')

<div class="container d-flex flex-column gap-4">

    <div class="row mb-2">


    

        <ul class="nav nav-pills nav-fill mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request('status') === '0' ? 'active' : '' }}" href="{{ route('managers.manageRooms', array_merge(request()->query(), ['status' => '0'])) }}">
                    Available
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === '1' ? 'active' : '' }}" href="{{ route('managers.manageRooms', array_merge(request()->query(), ['status' => '1'])) }}">
                    Occupied
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === '2' ? 'active' : '' }}" href="{{ route('managers.manageRooms', array_merge(request()->query(), ['status' => '2'])) }}">
                    Unavailable
                </a>
            </li>
         
           
        </ul>




    </div>
    <div class="row mb-2">


    

        <div class="nav nav-pills nav-fill" role="group" aria-label="Basic mixed styles example">

           

            @foreach ($roomTypes as $type)

    
            <a class="nav-link {{ request('room_type') == $type->id ? 'active' : '' }}" href="{{ route('managers.manageRooms', array_merge(request()->query(), ['room_type' => $type->id])) }}">
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

            <a role="div" href="{{ route('managers.roomDetail', ["id" => $room->id]) }}"
                class="card text-center text-decoration-none">

                <div class="card-body gy-5">
                    <h5 class="card-title">
                    
                    {{ $room->label }} 

                    
                    
                </h5>
                Type: <span class="badge bg-secondary mb-5">{{ $room->roomType->name }}</span>
                    <span class="card p-2 text-center text-bg-{{ $room->status == 0 ? 'success' : ($room->status == 1 ? 'secondary' : 'danger') }}">
                        {{ $room->status == 0 ? 'Available' : ($room->status == 1 ? 'Occupied' : 'Unavailable') }}
                    </span>

                </div>
               
</a>

        </div>

        @endforeach


    </div>

</div>  


@endsection