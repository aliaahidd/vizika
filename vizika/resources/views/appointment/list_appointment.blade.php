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

<!-- to display the alert message if the record has been deleted -->
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<div class="card">
    <div class="card-header pb-0">
        <div class="row">
            <div class=" {{  auth()->user()->category== 'Staff' ? 'col-lg-10 col-md-10 col-sm-10' : (request()->routeIs('appointment') ? 'col-lg-10 col-md-10 col-sm-10' : 'col-lg-12 col-md-12 col-sm-12') }}">
                <nav class="">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointment') ? 'active' : '' }}" href="{{ route('appointment') }}" role="tab" aria-selected="true">List Of appointment</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- if user == committee, then have add new appointment button  -->
            @if( auth()->user()->category== "Staff")

            @if(request()->routeIs('appointment'))
            <div class="col-lg-2 col-md-2 col-sm-2" style="float: right;">
                <a class="btn btn-primary" style="float: right; width:100%;" role="button" href="{{ route('appointment/choosevisitor') }}">
                    <i class="fas fa-plus"></i>&nbsp; Create Appointment</a>
            </div>
            @else
            <div class="col-lg-2 col-md-2 col-sm-2" style="float: right;">
                <a class="btn btn-success" style="float: right; width:100%;" role="button" href="">
                    <i class="fa fa-cog"></i>&nbsp; -</a>
            </div>
            @endif

            @endif

        </div>
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
                            <th>Appointment Name</th>
                            <th>Appointment Purpose</th>
                            <th>Visitor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointmentStaff As $key=>$data)
                        <tr id="row{{$data->id}}">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->appointmentDate }}</td>
                            <td>{{ $data->appointmentTime }}</td>
                            <td>{{ $data->appointmentName }}</td>
                            <td>{{ $data->appointmentPurpose }}</td>
                            <td>{{ $data->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif
                <!-- FOR STAFF TO VIEW RECORD APPOINTNMENT LIST END -->

                <!-- FOR VISITOR TO VIEW RECORD APPOINTMENT LIST START -->
                @if( auth()->user()->category== "Visitor")
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Appointment Name</th>
                            <th>Appointment Purpose</th>
                            <th>KANEKA Staff</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointmentVisitor As $key=>$data)
                        <tr id="row{{$data->id}}">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->appointmentName }}</td>
                            <td>{{ $data->appointmentDate }}</td>
                            <td>{{ $data->appointmentTime }}</td>
                            <td>{{ $data->appointmentPurpose }}</td>
                            <td>{{ $data->name }}</td>
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

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<Script>

</script>
@endsection