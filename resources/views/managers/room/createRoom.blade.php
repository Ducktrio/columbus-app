@extends('managers.base')


@section('outlet')

    <div class="container d-flex flex-column gap-4">

        <div class="row g-5">


            <div class="col-6">

                <h1>
                    Create new room
                </h1>

                <div class="card card-body text-bg-light">
                    <small class="text-muted">
                        [label] required, refer to room's display label.
</small>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
            </div>

            <div class="col-6">

                <form method="POST" action="{{ route('managers.createRoom.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="label" class="form-label">Room label</label>
                        <input class="form-control" id="label" name="label" aria-describedby="labelHelp">
                        <div id="labelHelp" class="form-text">The label that is displayed by the room's door.</div>
                    </div>
                    <div class="mb-3">
                        <label for="room_type_id" class="form-label">Room Type</label>
                        <select class="form-select" id="room_type_id" name="room_type_id">

                            @foreach ($roomTypes as $type)

                                <option value="{{ $type->id }}">{{ $type->name }}</option>

                            @endforeach

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>


            </div>


        </div>


    </div>

@endsection