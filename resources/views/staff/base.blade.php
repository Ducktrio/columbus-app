@extends('layouts.base')
@section('title', 'Staff Dashboard')
@section('content')

    <div class="d-flex flex-nowrap min-vh-100 position-relative">

        @include('staff.sidebar')

        <div className="container" style="flex: 1;padding: 4rem 12rem;">

            @yield('outlet')

        </div>


    </div>

@endsection