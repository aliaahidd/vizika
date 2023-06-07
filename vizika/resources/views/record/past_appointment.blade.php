@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Appointment</h1>
        <h6>Past Appointment List</h6>
    </div>
</div>

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
                searchPlaceholder: 'Search record'
            }
        });

        // filter appointment
        $('.dataTables_filter input[type="search"]').css({
            'width': '300px',
            'display': 'inline-block',
            'font-size': '15px',
            'font-weight': '400'
        });

        $('.year-dropdown').on('change', function(e) {
            var year = $(this).val();
            dataTable.column(3).search('^' + year + '-', true, false).draw();
        });
    });
</script>

<body>
    <!-- to display the alert message if the record has been deleted -->
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <!-- <div class=" {{  auth()->user()->category== 'Staff' ? 'col-lg-10 col-md-10 col-sm-10' : (request()->routeIs('appointment') ? 'col-lg-10 col-md-10 col-sm-10' : 'col-lg-12 col-md-12 col-sm-12') }}">
                <nav class="">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointment') ? 'active' : '' }}" href="{{ route('appointment') }}" role="tab" aria-selected="true">Visitor Appointment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointment') ? 'active' : '' }}" href="{{ route('appointment/createappointment') }}" role="tab" aria-selected="true">Contractor Appointment</a>
                        </li>
                    </ul>
                </nav>
            </div> -->
            </div>
        </div>

        <div class="card-body">
            <div class="overflow-auto" style="overflow:hidden;">
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Visitor Name</th>
                                <th>KANEKA Staff</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Purpose</th>
                                <th>Agenda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historyappointment As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->cont_visit_name }}</td>
                                <td>{{ $data->staff_name }}</td>
                                <td>{{ $data->checkInDate }} {{ $data->checkInTime }} </td>
                                <td>{{ $data->checkOutDate }} {{ $data->checkOutTime }} </td>
                                <td>{{ $data->appointmentPurpose }}</td>
                                <td>{{ $data->appointmentAgenda }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
@endsection