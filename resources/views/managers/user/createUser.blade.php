@extends("managers.base")

@section("outlet")

<div class="container d-flex flex-column gap-4">

    <div class="row">

        <div class="col">

            <h1>Create new user</h1>

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
        
        <div class="col">

            <form action="{{ route('managers.createUser.submit') }}" method="POST" novalidate autocomplete="off">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" rows="3" name="description"></textarea>
            </div>

            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>

                <select class="form-select" aria-label="Role" id="role_id" name="role_id" required>

                    @foreach ($roles as $role)
                    
                    <option value="{{ $role->id }}">{{ $role->title }}</option>
                        
                    @endforeach

                </select>

            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        </div>

    </div>


    <div class="row">

    

    </div>

</div>

@endsection
