@extends('receptionist.base')



@section('outlet')


<div class="container d-flex flex-column gap-4">

    <div class="row">

        <!-- Available Rooms Info -->
        <div class="col-4">

            <div class="card border mb-3">
                <div class="card-header">Available Rooms</div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h1 class="card-title">{{ $roomCount }}</h1>
                </div>
            </div>

        </div>

        <div class="col-4">
            <div class="card border mb-3">
                <div class="card-header">Available Rooms</div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h1 class="card-title">{{ $roomCount }}</h1>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card border mb-3">
                <div class="card-header">Available Rooms</div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h1 class="card-title">{{ $roomCount }}</h1>
                </div>
            </div>          
        </div>

 
    </div>


    <div class="row">

        <h1>Quick Action</h1>

    </div>


</div>

@endsection