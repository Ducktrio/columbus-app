@extends("managers.base")

@section("outlet")

<div class="container d-flex flex-column gap-4">

    <div class="row">

        <h1>Create new user</h1>
    </div>


    <div class="row">

        <form action="{{ route('managers.createUser.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password">
            </div>

            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>

                <select class="form-select" aria-label="Role">

                    @foreach ($roles as $role)
                    
                    <option value="{{ $role->id }}">{{ $role->title }}</option>
                        
                    @endforeach

                </select>

            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>

    </div>

</div>

@endsection
