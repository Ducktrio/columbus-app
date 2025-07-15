@extends('receptionist.base')

@section('outlet')

    <div class="row">
        <h1 class="mb-5">Checkout</h1>

        <input type="search" class="form-control mb-4" placeholder="Search by room number or customer name" id="search">


        <div class="row" id="lists">

                @include('receptionist.partials.checkList', ['roomTickets' => $roomTickets])
        </div>


    </div>

@endsection

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        let query = "";

        $('#search').on('keyup', function () {
            query = $(this).val();
            $.ajax({
                url: "{{ route('reception.checkout') }}",
                type: 'GET',
                data: { search: query },
                success: function (data) {
                    $('#lists').html(data.html);
                }
            });
        });

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#rooms-list').html(data.htmlRooms);
                    $('#customers-list').html(data.htmlCustomers);
                }
            });
        });
    });
</script>