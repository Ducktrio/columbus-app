@extends("managers.base")

@section("outlet")

<div class="container d-flex flex-column gap-4">

    <div class="row">

        <h1>Registered Users</h1>

 
    </div>

    <div class="row">

        @foreach ($users as $user)

        <div class="col-4">


            <button data-bs-toggle="collapse" href="#details-{{ $user->id }}"
            role="div" class="card mb-3 text-start" style="min-width: 240px;"
         >
                <div class="row g-2" data-bs-toggle="tooltip" data-bs-title="Click for details">
                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-circle img-fluid text-secondary fs-1"></i>
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->username }}</h5>
                        <p class="card-text"><span class="badge text-bg-secondary">{{  $user->role->title }}</span></p>
                    </div>
                    </div>
                </div>
</button>
            <div class="collapse" id="details-{{ $user->id }}">
                <div class="card card-body">
                    {{ $user->description }}
                    <hr>
                    Created at: {{ $user->created_at }}
                    <br>
                    Last update: {{ $user->updated_at }} 
                    <hr>
                    ID: {{ $user->id }}
                    <hr>
                    <form action="{{ route('managers.deleteUser', ['id' => $user->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete User</button>
                        </form>
                </div>
            </div>


        </div>
            
        @endforeach

    </div>
</div>




@endsection