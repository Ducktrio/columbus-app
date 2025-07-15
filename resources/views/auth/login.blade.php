
@extends('layouts.base')

@section('title', 'Login')

@section('content')
    <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100 w-100">

    <div class="card shadow-sm mx-auto" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h3 class="mb-4 text-center">{{ config('app.name')}}</h3>

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

        </div>
    </div>
    </div>
@endsection
