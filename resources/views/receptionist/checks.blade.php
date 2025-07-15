@extends('receptionist.base')


@section('outlet')


    <div class="row">

        <h2 class="mb-5">Room Checks</h2>

        <ul class="nav nav-tabs nav-fill mb-5">

            <li class="nav-item">
                <a class="nav-link {{ request()->query('filter') === '0' ? 'active' : '' }}"
                    href="{{ route('reception.checks', ['filter' => "0"]) }}">Pending Check In
                    @if (\App\Models\RoomTicket::query()->whereNull('check_in')->count() > 0)
                        <span
                            class="badge rounded-pill bg-danger ms-2">{{ \App\Models\RoomTicket::query()->whereNull('check_in')->count() }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{  request()->query('filter') === '1' ? 'active' : '' }}"
                    href="{{  route('reception.checks', ['filter' => "1"]) }}">Checked In


                </a>
            </li>
        </ul>

        <div class="row">

            <div class="mb-4">
                <input type="search" class="form-control" placeholder="Search by room number or customer name" id="search">
            </div>

            <div id="lists" class="row g-4">

                @include('receptionist.partials.checkList', ['roomTickets' => $roomTickets])

            </div>

        </div>

    </div>



@endsection

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>
    $(document).ready(function () {

        $('#search').on('keyup', function () {
            let query = $(this).val();
            $.ajax({
                url: "{{ route('reception.checks') }}",
                type: 'GET',
                data: { search: query },
                success: function (data) {
                    $('#lists').html(data.html);
                }
            });
        });
    });
</script>