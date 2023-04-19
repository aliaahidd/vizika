@extends('layouts.sideNav')
@section('content')

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script>
    // to search the appointment 
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [0, "asc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search name'
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

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0 d-flex">
        <h1 class="page-title ml-3">Dashboard</h1>
    </div>
</div>

<!-- Dashboard information start -->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">person</i>
                    </div>
                    <div class="col-8">
                        <h1>75</h1>
                        <span>Total Visitor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">event</i>
                    </div>
                    <div class="col-8">
                        <h1>356</h1>
                        <span>Total Appointment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">event</i>
                    </div>
                    <div class="col-8">
                        <h1>20</h1>
                        <span>Total Checkin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">event</i>
                    </div>
                    <div class="col-8">
                        <h1>25</h1>
                        <span>Total Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<!-- Dashboard information end -->

@if( auth()->user()->category== "SHEQ Guard")
<h6>
    <?php
    date_default_timezone_set("Asia/Kuala_Lumpur");
    echo date('l, d-m-Y H:i:s');
    ?>
</h6>
@endif
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Visitor Log</h5>
            </div>
            <div class="card-body">
                <div class="overflow-auto" style="overflow:auto;">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Visitor Name</th>
                                    <th>KANEKA Staff</th>
                                    <th>Purpose</th>
                                    <th>Agenda</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($visitorlog As $key=>$data)
                                <tr id="row{{$data->recordID}}">
                                    <td>{{ $data->recordID }}</td>
                                    <td>{{ $data->cont_visit_name }}</td>
                                    <td>{{ $data->staff_name }}</td>
                                    <td>{{ $data->appointmentPurpose }}</td>
                                    <td>{{ $data->appointmentAgenda }}</td>
                                    <td>{{ $data->checkInDate }} {{ $data->checkInTime }}</td>
                                    <td>
                                        @if($data->checkOutTime == NULL)
                                        <div class="btn-group">
                                            <a class="btn btn-primary" style="color: white" href="{{ route('checkout', $data->recordID) }}">Check Out</a>&nbsp
                                        </div>
                                        @else
                                        {{ $data->checkOutDate }} {{ $data->checkOutTime }}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection