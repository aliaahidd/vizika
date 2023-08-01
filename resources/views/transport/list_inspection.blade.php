@extends('layouts.sideNav')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header row no-gutters">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Transport</h1>
        <h6>List Transport Inspection</h6>
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

        @if(request()->routeIs('transportInspection'))
        <div class="col-lg-12 col-md-6 col-sm-3 justify-content-end d-flex">
            <a class="btn btn-primary" style="width:170px;" role="button" href="{{ route('transportInspection/inspectionform') }}">
                <i class="fas fa-plus"></i>&nbsp; Inspection Form</a>
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
                            <tr class="text-center">
                                <th rowspan="2">ID</th>
                                <th rowspan="2">Date</th>
                                <th rowspan="2">Plate No</th>
                                <th rowspan="2">Company Name</th>
                                <th colspan="2">Prime Mover</th>
                                <th colspan="4">Trailer</th>
                                <th rowspan="2">Security</th>
                            </tr>
                            <tr>
                                <th>Inside</th>
                                <th>Back</th>
                                <th>Behind</th>
                                <th>Under</th>
                                <th>Left</th>
                                <th>Right</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inspectionList As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->inspectionID }}</td>
                                <td>{{ $data->visitDate }}</td>
                                <td>{{ $data->vehicleRegNo }}</td>
                                <td>{{ $data->companyName }}</td>
                                <td>
                                    @if ($data->primeMoverInside == "on")
                                    <i class="fas fa-check text-success"></i> <!-- Tick icon -->
                                    @else
                                    <i class="fas fa-times text-danger"></i> <!-- Cross icon -->
                                    @endif
                                </td>
                                <td>
                                    @if ($data->primeMoverBack == "on")
                                    <i class="fas fa-check text-success"></i> <!-- Tick icon -->
                                    @else
                                    <i class="fas fa-times text-danger"></i> <!-- Cross icon -->
                                    @endif
                                </td>
                                <td>
                                    @if ($data->trailerUnder == "on")
                                    <i class="fas fa-check text-success"></i> <!-- Tick icon -->
                                    @else
                                    <i class="fas fa-times text-danger"></i> <!-- Cross icon -->
                                    @endif
                                </td>
                                <td>
                                    @if ($data->trailerBehind == "on")
                                    <i class="fas fa-check text-success"></i> <!-- Tick icon -->
                                    @else
                                    <i class="fas fa-times text-danger"></i> <!-- Cross icon -->
                                    @endif
                                </td>
                                <td>
                                    @if ($data->trailerLeft == "on")
                                    <i class="fas fa-check text-success"></i> <!-- Tick icon -->
                                    @else
                                    <i class="fas fa-times text-danger"></i> <!-- Cross icon -->
                                    @endif
                                </td>
                                <td>
                                    @if ($data->trailerRight == "on")
                                    <i class="fas fa-check text-success"></i> <!-- Tick icon -->
                                    @else
                                    <i class="fas fa-times text-danger"></i> <!-- Cross icon -->
                                    @endif
                                </td>
                                <td>{{ $data->security }}</td>
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