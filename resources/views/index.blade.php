@extends('layouts.base')

@section("title", "Columbus - Management System")

@section('content')

    <div id="bg-animate" class="container-fluid d-flex flex-column align-items-center justify-content-center min-vh-100 w-100">

        <h1>{{ config('app.name') }}</h1>
        <small>Hotel Management System - {{ config('app.company') }}</small>

        <hr>

        <a role="button" class="btn btn-primary" href="{{ route('login') }}">Login</a>

    </div>
