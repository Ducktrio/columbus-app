@extends('receptionist.base')


@section('outlet')

    <div class="row mb-5">
        <h1>Rooms</h1>
    </div>

    <div class="row mb-5">
        <ul class="nav nav-pills nav-fill">

            <li class="nav-item fs-4 d-grid gap-2 p-2">
                <a class="nav-link {{ request('status') === '0' ? 'active' : '' }}"
                    href="{{ route('reception.rooms', array_merge(request()->query(), ['status' => '0'])) }}">
                    Available

                </a>
                <div class="card card-body text-center text-bg-light">
                    <span class="fs-1">{{ \App\Models\Room::query()->where('status', 0)->count() }}</span>
                </div>
            </li>

            <li class="nav-item fs-4 d-grid gap-2 p-2">
                <a class="nav-link {{ request('status') === '1' ? 'active' : '' }}"
                    href="{{ route('reception.rooms', array_merge(request()->query(), ['status' => '1'])) }}">
                    Occupied

                </a>
                <div class="card card-body text-center text-bg-light">
                    <span class="fs-1">{{ \App\Models\Room::query()->where('status', 1)->count() }}</span>
                </div>
            </li>

            <li class="nav-item fs-4 d-grid gap-2 p-2">
                <a class="nav-link {{ request('status') === '2' ? 'active' : '' }}"
                    href="{{ route('reception.rooms', array_merge(request()->query(), ['status' => '2'])) }}">
                    Unavailable

                    @if(\App\Models\Room::query()->where('status', 2)->count() > 0)
                        <div class="spinner-grow text-warning" role="status">
                            <span class="visually-hidden">Warning</span>
                        </div>
                    @endif
                </a>
                <div class="card card-body text-center text-bg-light">
                    <span class="fs-1">{{ \App\Models\Room::query()->where('status', 2)->count() }}</span>
                    
                </div>
            </li>

        </ul>
    </div>

    <hr class="mb-5">


    <div class="row mb-2" id="lists">

        @foreach($rooms as $room)

            <div class="col-4 g-4">

                @include('components.room', ['room' => $room, 'target' => 'reception.roomDetail'])


            </div>

        @endforeach

    </div>

    {{ $rooms->links() }}

@endsection