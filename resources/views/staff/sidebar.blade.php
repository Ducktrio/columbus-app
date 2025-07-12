<!-- Navbar -->
<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary vh-100 position-sticky top-0 left-0"
    style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-black text-decoration-none">
        <span class="fs-4">Columbus</span>
    </a>
    <small class="fst-italic">Staff Panel</small>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">

        <!-- Tickets -->
        @php
            $services = \App\Models\Service::all();
            $currentServiceId = request()->query('service_id');
        @endphp

        @foreach($services as $service)
            <li class="nav-item">
                <a href="{{ route('staff.dashboard') }}?service_id={{ $service->id }}"
                    class="nav-link {{ $currentServiceId == $service->id ? 'active' : 'text-black' }}">
                    <i class="bi bi-ticket pe-none me-2"></i>
                    {{ $service->name }}

                    @if($service->serviceTickets()->where('status', 0)->count() > 0)
                    <span class="badge text-bg-danger rounded-pill float-end">
                        {{ $service->serviceTickets()->where('status', 0)->count() }}
                    </span>
                    @endif
                </a>
            </li>
        @endforeach

        
    </ul>

    <hr>

    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-badge-fill pe-none me-2 fs-3"></i>
            @auth
            <strong>{{ auth()->user()->username }}</strong>
            @endauth
            @guest
            <strong>Guest</strong>
            @endguest
        </a>
        <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
        </ul>
    </div>
</div>