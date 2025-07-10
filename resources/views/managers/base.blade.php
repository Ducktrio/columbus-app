@extends('layouts.base')

@section('title', "Manager Panel | Columbus")
@section('content')
<div class="d-flex flex-nowrap min-vh-100">


    <!-- Navbar -->
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;"> <a href="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-black text-decoration-none">
            <span class="fs-4">Columbus</span> 
        </a>
        <small class="fst-italic">Manager Panel</small>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">

        <!-- List Users -->
            <li class="nav-item"> 
                <a href="{{ route('managers.listUsers') }}" class="nav-link {{ request()->routeIs("managers.listUsers") ?   'active' : 'text-black' }}" aria-current="page"> 
                        <i class="bi bi-person-circle pe-none me-2">
                        <use xlink:href="#home">
                        </use>
                        </i>
                        List Users
                </a>
            </li>

        <!-- Register Users -->
            <li class="nav-item"> 
                <a href="{{ route('managers.createUser') }}" class="nav-link {{ request()->routeIs("managers.createUser") ?   'active' : 'text-black' }}" aria-current="page">
                        <i class="bi bi-file-plus-fill pe-none me-2">
                        <use xlink:href="#register">
                        </use>
                        </i>
                        Register New User
                </a>
            </li>

            <hr>

            <!-- Manage rooms -->
            <li class="nav-item"> 
                <a href="{{ route('managers.manageRooms') }}" class="nav-link {{ request()->routeIs("managers.manageRooms") ?   'active' : 'text-black' }}" aria-current="page">
                        <i class="bi bi-{{ request()->routeIs('managers.manageRooms')? "door-open-fill" : 'door-closed' }} pe-none me-2">
                        <use xlink:href="#manageRooms">
                        </use>
                        </i>
                        Manage Rooms
                </a>
            </li>

            <!-- Create rooms -->
            <li class="nav-item"> 
                <a href="{{ route('managers.createRoom') }}" class="nav-link {{ request()->routeIs("managers.createRoom") ?   'active' : 'text-black' }}" aria-current="page">
                        <i class="bi bi-{{ request()->routeIs('managers.createRoom')? "door-open-fill" : 'door-closed' }} pe-none me-2">
                        <use xlink:href="#createRoom">
                        </use>
                        </i>
                        Create Room
                </a>
            </li>
          
        </ul>
        
        <hr>

        <div class="dropdown">
            <a href="#"
                class="d-flex align-items-center text-black text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false"> 
                <i class="bi bi-person-badge-fill pe-none me-2 fs-3"></i>
                <strong>{{ auth()->user()->username }}</strong> 
            </a>
            <ul class="dropdown-menu text-small shadow">
                  <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
            </ul>
        </div>
    </div>

    <div className="container" style="flex: 1;padding: 4rem 12rem;">

        @yield("outlet")

    </div>
</div>
@endsection