@extends('layouts.base')

@section('title', "Reception | Columbus")
@section('content')
<div class="d-flex min-vh-100 w-100">

    <div class="col-3 d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;"> <a href="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-black text-decoration-none">
            <span class="fs-4">Columbus</span> 
        </a>
        <small class="fst-italic">Receiptionist Panel</small>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">

        <!-- Dashboard -->
            <li class="nav-item"> 
                <a href="{{ route('managers.listUsers') }}" class="nav-link {{ request()->routeIs("reception") ?   'active' : 'text-black' }}" aria-current="page"> 
                        <i class="bi {{ request()->routeIs("reception") ? "bi-house-fill":"bi-house"}} pe-none me-2">
                            <use xlink:href="#home">
                            </use>
                        </i>
                        Dashboard
                </a>
            </li>

            <hr>

        <!-- Room management -->
            <li class="nav-item"> 
                <a href="{{ route('managers.createUser') }}" class="nav-link {{ request()->routeIs("reception.checkin") ?   'active' : 'text-black' }}" aria-current="page">
                        <i class="bi {{ request()->routeIs("reception.checkin")? 'bi-door-open-fill' : 'bi-door-open' }} pe-none me-2">
                            <use xlink:href="#checkin">
                            </use>
                        </i>
                        Room Check In
                </a>
            </li>

            <li class="nav-item"> 
                <a href="{{ route('managers.createUser') }}" class="nav-link {{ request()->routeIs("receiption.checkout") ?   'active' : 'text-black' }}" aria-current="page">
                        <i class="bi {{ request()->routeIs("receiption.checkout")? 'bi-door-closed-fill' : 'bi-door-closed' }} pe-none me-2">
                            <use xlink:href="#checkout">
                            </use>
                        </i>
                        Room Check Out
                </a>
            </li>
          
        </ul>
        <hr>
        <div class="dropdown"> <a href="#"
                class="d-flex align-items-center text-black text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false"> 
                                        <i class="bi bi-person-badge-fill pe-none me-2 fs-3"></i>
                <strong>{{ auth()->user()->username }}</strong> </a>
            <ul class="dropdown-menu text-small shadow">
                  <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
            </ul>
        </div>
    </div>

    <div className="col-9 container-fluid flex-1" style="padding: 4rem 12rem;">

        @yield("outlet")

    </div>
</div>
@endsection

@include('components.toast')
