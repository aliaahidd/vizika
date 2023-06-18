@extends('layouts.sideNav')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header row no-gutters">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Appointment</h1>
        <h6>List Appointment</h6>
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

        <!-- if user == committee, then have add new appointment button  -->
        @if( auth()->user()->category== "Staff")

        @if(request()->routeIs('appointment'))
        <div class="col-lg-12 col-md-6 col-sm-3 justify-content-end d-flex">
            <a class="btn btn-primary" style="width:170px;" role="button" href="{{ route('appointment/createappointment') }}">
                <i class="fas fa-plus"></i>&nbsp; Create Appointment</a>
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
                    <!-- FOR STAFF TO VIEW RECORD APPOINTMENT LIST START -->
                    @if( auth()->user()->category== "Staff")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Appointment Purpose</th>
                                <th>Appointment Agenda</th>
                                <th>Visitor</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointmentStaff As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->appointmentID }}</td>
                                <td>{{ $data->appointmentDate }}</td>
                                <td>{{ $data->appointmentTime }}</td>
                                <td>{{ $data->appointmentPurpose }}</td>
                                <td>{{ $data->appointmentAgenda }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <!-- if status == pending then color status = blue -->
                                        @if($data->appointmentStatus =='Pending')
                                        <div style="background-color: #dff0fa; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto; width: 100px">
                                            <label style=" color: #2d9cdb; text-align: center; font-weight: bold" class="mb-1 mt-1">{{ $data->appointmentStatus }}</label>
                                        </div>
                                        <!-- if status == pending then color status = green -->
                                        @elseif($data->appointmentStatus =='Attend')
                                        <div style="background-color: #d9f3ea; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto; width: 100px">
                                            <label style=" color: #0bb37a; text-align: center; font-weight: bold" class="mb-1 mt-1">{{ $data->appointmentStatus }}</label>
                                        </div>
                                        <!-- if status == pending then color status = red -->
                                        @elseif($data->appointmentStatus =='Not Attend')
                                        <div style="background-color: #ffe6e6; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto; width: 100px">
                                            <label style=" color: #ff5b5b; text-align: center; font-weight: bold" class="mb-1 mt-1">{{ $data->appointmentStatus }}</label>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @endif
                    <!-- FOR STAFF TO VIEW RECORD APPOINTNMENT LIST END -->

                    <!-- FOR VISITOR TO VIEW RECORD APPOINTMENT LIST START -->
                    @if( auth()->user()->category== "Visitor" || auth()->user()->category== "Contractor")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Appointment Name</th>
                                <th>Appointment Purpose</th>
                                <th>KANEKA Staff</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointmentVisitor as $key => $data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->appointmentDate }}</td>
                                <td>{{ $data->appointmentTime }}</td>
                                <td>{{ $data->appointmentPurpose }}</td>
                                <td>{{ $data->appointmentAgenda }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if($data->appointmentStatus =='Pending')
                                        <a class="btn btn-success" style="color: white" href="{{ route('attendvisit', $data->appointmentID) }}">Attend</a>&nbsp
                                        <a class="btn btn-danger" style="color: white" href="{{ route('notattendvisit', $data->appointmentID) }}">Not Attend</a>
                                        @elseif($data->appointmentStatus =='Attend')
                                        <div style="background-color: #d9f3ea; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto; width: 100px">
                                            <label style="color: #0bb37a; text-align: center; font-weight: bold" class="mb-1 mt-1">{{ $data->appointmentStatus }}</label>
                                        </div>
                                        @elseif($data->appointmentStatus =='Not Attend')
                                        <div style="background-color: #ffe6e6; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto; width: 100px">
                                            <label style="color: #ff5b5b; text-align: center; font-weight: bold" class="mb-1 mt-1">{{ $data->appointmentStatus }}</label>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    @endif
                    <!-- FOR VISITOR TO VIEW RECORD APPOINTNMENT LIST END -->
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
    // to search the appointment 
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [1, "desc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search appointment'
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