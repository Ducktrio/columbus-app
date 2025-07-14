@extends('layouts.base')

@section('title', "Reception | Columbus")
@section('content')
    <div class="d-flex flex-nowrap min-vh-100 position-relative">

        <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary vh-100 position-sticky top-0 left-0">

            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-black text-decoration-none">
                <span class="fs-4">Columbus</span>
            </a>
            <small class="fst-italic">Receiptionist Panel</small>

            <hr>

            <ul class="nav nav-pills flex-column mb-auto">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('reception') }}"
                        class="nav-link {{ request()->routeIs("reception") ? 'active' : 'text-black' }}"
                        aria-current="page">
                        <i class="bi {{ request()->routeIs("reception") ? "bi-house-fill" : "bi-house"}} pe-none me-2">
                            <use xlink:href="#home">
                            </use>
                        </i>
                        Dashboard
                    </a>
                </li>

                <hr>

                <!-- Room management -->
                <li class="nav-item">
                    <a href="{{ route('reception.checkin') }}"
                        class="nav-link {{ request()->routeIs("reception.checkin") ? 'active' : 'text-black' }}"
                        aria-current="page">
                        <i
                            class="bi {{ request()->routeIs("reception.checkin") ? 'bi-door-open-fill' : 'bi-door-open' }} pe-none me-2">
                            <use xlink:href="#checkin">
                            </use>
                        </i>
                        Room Check In
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('managers.createUser') }}"
                        class="nav-link {{ request()->routeIs("receiption.checkout") ? 'active' : 'text-black' }}"
                        aria-current="page">
                        <i
                            class="bi {{ request()->routeIs("receiption.checkout") ? 'bi-door-closed-fill' : 'bi-door-closed' }} pe-none me-2">
                            <use xlink:href="#checkout">
                            </use>
                        </i>
                        Room Check Out
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('reception.checks') }}"
                        class="nav-link {{ request()->routeIs("reception.checks") ? 'active' : 'text-black' }}"
                        aria-current="page">
                        <i
                            class="bi {{ request()->routeIs("reception.checks") ? 'bi-check2-square' : 'bi-check2-square' }} pe-none me-2">
                            <use xlink:href="#checks">
                            </use>
                        </i>
                        Room Checks
                    </a>
                </li>

            </ul>
            <hr>

            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false"
                    class="d-flex align-items-center text-black text-decoration-none dropdown-toggle">
                    <i class="bi bi-person-badge-fill pe-none me-2 fs-3"></i>
                    <strong>{{ auth()->user()->username }}</strong> </a>
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

@include('components.toast')