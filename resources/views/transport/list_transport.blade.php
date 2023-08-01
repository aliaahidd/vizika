@extends('layouts.sideNav')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header row no-gutters">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Transport</h1>
        <h6>List Transport</h6>
    </div>
</div>

@if( auth()->user()->category== "SHEQ Guard")
<h6>
    <?php
    date_default_timezone_set("Asia/Kuala_Lumpur");
    echo date('l, d-m-Y H:i:s');
    ?>
</h6>
@endif

<body>
    <!-- to display the alert message if the record has been deleted -->
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <div class="row mb-3">

        @if( auth()->user()->category== "SHEQ Guard")

        @if(request()->routeIs('transport'))
        <div class="col-lg-12 col-md-6 col-sm-3 justify-content-end d-flex">
            <a class="btn btn-primary" style="width:170px;" role="button" href="{{ route('transport/registerTransport') }}">
                <i class="fas fa-plus"></i>&nbsp; Register Transport</a>
        </div>
        @endif

        @endif

    </div>
    <div class="card">
        <div class="card-header pb-0">

        </div>

        <div class="card-body">
            <div class="overflow-auto" style="overflow:auto;">
                <div class="table-responsive">
                    <!-- FOR SHEQ GUARD TO VIEW TRANSPORT LIST START -->
                    @if( auth()->user()->category== "SHEQ Guard")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company</th>
                                <th>Reg. No</th>
                                <th>Name</th>
                                <th>IC No</th>
                                <th>Plant</th>
                                <th>Check-In</th>
                                <th>CheckOut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transportList As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->transportID }}</td>
                                <td>{{ $data->companyName }}</td>
                                <td>{{ $data->vehicleRegNo }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->icNo }}</td>
                                <td>{{ $data->plant }}</td>
                                <td>{{ $data->checkInDate }} {{ $data->checkInTime }}</td>
                                <td>{{ $data->checkOutDate }} {{ $data->checkOutTime }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @endif
                    <!-- FOR SHEQ GUARD TO VIEW TRANSPORT LIST END -->
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script>
    // to search the transport 
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [1, "desc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search transport'
            }
        });

        // filter appointment
        $('.dataTables_filter input[type="search"]').css({
            'width': '300px',
            'display': 'inline-block',
            'font-size': '15px',
            'font-weight': '400'
        });
    });
</script>