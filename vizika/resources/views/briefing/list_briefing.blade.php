@extends('layouts.sideNav')

@section('content')
<h4>Safety Briefing</h4>
<h6>Briefing List</h6>

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
                searchPlaceholder: 'Search briefing'
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

                @if( auth()->user()->category== "SHEQ Officer")

                @if(request()->routeIs('briefing'))
                <div class="col-lg-2 col-md-2 col-sm-2" style="float: right;">
                    <a class="btn btn-primary" style="float: right; width:100%;" role="button" href="{{ route('briefing/createbriefinginfo') }}">
                        <i class="fas fa-plus"></i>&nbsp; Create Briefing</a>
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
            <div class="overflow-auto" style="overflow:hidden;">
                <div class="table-responsive">
                    @if( auth()->user()->category== "SHEQ Officer")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Time Start</th>
                                <th>Time End</th>
                                <th>Participant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($briefinginfolist As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->briefingDate }}</td>
                                <td>{{ $data->briefingTimeStart }}</td>
                                <td>{{ $data->briefingTimeEnd }}</td>
                                <td>{{ $data->maxParticipant }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    @if( auth()->user()->category== "Contractor")
                    @if ($alreadyenroll)
                    <div class="container">
                        <div class="row justify-content-md-center">
                            <div class="col d-flex justify-content-center">
                                <h2>You already enroll in safety briefing</h2>
                            </div>
                        </div>
                        <br>
                        @foreach($briefingenrollmentdetails As $key=>$data)
                        
                        <table  style="margin-left: auto; margin-right: auto;" id="dataTable" width="30%" cellspacing="0">
                            <tr>
                                <td><h5><i class="material-icons">event</i><span> Date</span></h5></td>
                                <td><h5>{{ $data->briefingDate }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5><i class="material-icons">schedule</i><span> Time Start</span></h5></td>
                                <td><h5>{{ $data->briefingTimeStart }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5><i class="material-icons">schedule</i><span> Time End</span></h5></td>
                                <td><h5>{{ $data->briefingTimeEnd }}</h5></td>
                            </tr>
                        </table>
                    </div>
                    @endforeach

                    @else
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Time Start</th>
                                <th>Time End</th>
                                <th>Total Participant</th>
                                <th>Enroll</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($briefinginfolist As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->briefingDate }}</td>
                                <td>{{ $data->briefingTimeStart }}</td>
                                <td>{{ $data->briefingTimeEnd }}</td>
                                <td>{{ $data->totalParticipants ?? 0 }}/{{ $data->maxParticipant }}</td>
                                <td>
                                    @if ($data->enrollmentOpen)
                                    <a class="btn btn-primary" href="{{ route('enrollbriefing', $data->id) }}">Enroll</a>
                                    @else
                                    <label>Already full</label>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
@endsection