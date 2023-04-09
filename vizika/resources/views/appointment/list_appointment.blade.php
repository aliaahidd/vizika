@extends('layouts.sideNav')

@section('content')
<h4>Appointment</h4>
<h6>Appointment List</h6>
@if( auth()->user()->category== "SHEQ Guard")
<h6>
    <?php
    date_default_timezone_set("Asia/Kuala_Lumpur");
    echo date('l, d-m-Y H:i:s');
    ?>
</h6>
@endif

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

                <!-- if user == committee, then have add new appointment button  -->
                @if( auth()->user()->category== "Staff")

                @if(request()->routeIs('appointment'))
                <div class="col-lg-2 col-md-2 col-sm-2" style="float: right;">
                    <a class="btn btn-primary" style="float: right; width:100%;" role="button" href="{{ route('appointment/createappointment') }}">
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
                                <th>Appointment Purpose</th>
                                <th>Appointment Agenda</th>
                                <th>Visitor</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointmentStaff As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->appointmentDate }}</td>
                                <td>{{ $data->appointmentTime }}</td>
                                <td>{{ $data->appointmentPurpose }}</td>
                                <td>{{ $data->appointmentAgenda }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <!-- if status == pending then color status = blue -->
                                        @if($data->appointmentStatus =='Pending')
                                        <p style="color: #007bff">{{ $data->appointmentStatus }}</p>
                                        <!-- if status == pending then color status = green -->
                                        @elseif($data->appointmentStatus =='Attend')
                                        <p style="color: green">{{ $data->appointmentStatus }}</p>
                                        <!-- if status == pending then color status = red -->
                                        @elseif($data->appointmentStatus =='Not Attend')
                                        <p style="color: red">{{ $data->appointmentStatus }}</p>
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
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointmentVisitor As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->appointmentDate }}</td>
                                <td>{{ $data->appointmentTime }}</td>
                                <td>{{ $data->appointmentPurpose }}</td>
                                <td>{{ $data->appointmentAgenda }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <!-- if status == pending then color status = blue -->
                                        @if($data->appointmentStatus =='Pending')
                                        <a class="btn btn-success" style="color: white" href="{{ route('attendvisit', $data->appointmentID) }}">Attend</a>&nbsp
                                        <a class="btn btn-danger" style="color: white" href="{{ route('notattendvisit', $data->appointmentID) }}">Not Attend</a>
                                        <!-- if status == pending then color status = green -->
                                        @elseif($data->appointmentStatus =='Attend')
                                        <p style="color: green">{{ $data->appointmentStatus }}</p>
                                        <!-- if status == pending then color status = red -->
                                        @elseif($data->appointmentStatus =='Not Attend')
                                        <p style="color: red">{{ $data->appointmentStatus }}</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @endif
                    <!-- FOR VISITOR TO VIEW RECORD APPOINTNMENT LIST END -->

                    <!-- FOR GUARD TO VIEW RECORD APPOINTMENT LIST START -->
                    @if( auth()->user()->category== "SHEQ Guard")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Visitor Name</th>
                                <th>KANEKA Staff</th>
                                <th>Purpose</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointmentGuard As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->cont_visit_name }}</td>
                                <td>{{ $data->staff_name }}</td>
                                <td>{{ $data->appointmentPurpose }}</td>

                                @if( $data->category == "Visitor")
                                <td><a href="javascript:void(0)" class="btn btn-primary" id="show-visitor" style="color: white" data-url="{{ route('visitor.showV', $data->contVisitID) }}">View</a>
                                    @elseif( $data->category == "Contractor")
                                <td><a href="javascript:void(0)" class="btn btn-primary" id="show-contractor" style="color: white" data-url="{{ route('contractor.showC', $data->contVisitID) }}">View</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @endif
                    <!-- FOR GUARD TO VIEW RECORD APPOINTNMENT LIST END -->
                </div>
            </div>
        </div>

        <!-- MODAL BOX -->
        <!-- To display the modal box if reject button is clicked to enter the feedback comment -->
        <div class="modal fade" id="visitorShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="top: 100px; right: 100px">
                <div class="modal-content" style="width: 800px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-5">
                                <img id="v-photo" width="200px">
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-5">
                                        <label>Name</label>
                                    </div>
                                    <div class="col">
                                        <label><span id="v-name"></span></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label>Email</label>
                                    </div>
                                    <div class="col">
                                        <label><span id="v-email"></span></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label>Phone No</label>
                                    </div>
                                    <div class="col">
                                        <label><span id="v-phoneNo"></span></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label>Company Name</label>
                                    </div>
                                    <div class="col">
                                        <label><span id="v-companyName"></span></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label>Occupation</label>
                                    </div>
                                    <div class="col">
                                        <label><span id="v-occupation"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="#" id="v-link" class="btn btn-primary" data-bs-dismiss="modal"><span id="v-text">Check-in</span></a>
                        <div id="v-id" style="display: none"></div>

                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL BOX -->
        <!-- To display the modal box if reject button is clicked to enter the feedback comment -->
        <div class="modal fade" id="contractorShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="top: 100px; right: 100px">
                <div class="modal-content" style="width: 800px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-5">
                                <img id="c-photo" width="200px">
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-5">
                                        <label>Name</label>
                                    </div>
                                    <div class="col">
                                        <label><span id="c-name"></span></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label>Email</label>
                                    </div>
                                    <div class="col">
                                        <label><span id="c-email"></span></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label>Phone No</label>
                                    </div>
                                    <div class="col">
                                        <label><span id="c-phoneNo"></span></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label>Company Name</label>
                                    </div>
                                    <div class="col">
                                        <label><span id="c-companyName"></span></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label>Expiry Validity Pass</label>
                                    </div>
                                    <div class="col">
                                        <label><span id="c-pass"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="#" id="c-link" class="btn btn-primary" data-bs-dismiss="modal"><span id="c-text">Check-in</span></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('body').on('click', '#show-visitor', function() {
            var userURL = $(this).data('url');
            $.get(userURL, function(data) {
                $('#visitorShowModal').modal('show');
                $('#v-id').text(data.appointmentID);
                $('#v-id').attr('data-appointment-id', data.appointmentID);
                $('#v-name').text(data.name);
                $('#v-email').text(data.email);
                $('#v-phoneNo').text(data.phoneNo);
                $('#v-companyName').text(data.companyName);
                $('#v-occupation').text(data.occupation);
                $('#v-photo').attr('src', '/assets/' + data.passportPhoto);

                var link = '{{ route("checkin-visitor", ":id") }}';
                link = link.replace(':id', data.appointmentID);
                $('#v-link').attr('href', link);
                $('#v-text').text('Check-In');
            })
        });

        $('body').on('click', '#v-link', function(event) {
            event.preventDefault(); // prevent the default behavior of the link
            var appointmentID = $('#v-id').attr('data-appointment-id');
            var link = '{{ route("checkin-visitor", ":id") }}';
            link = link.replace(':id', appointmentID);
            $('#v-link').attr('href', link);
            $('#v-text').text('Check-In'); // reset button text
            window.location.href = link; // redirect the user to the new page
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $('body').on('click', '#show-contractor', function() {
            var userURL = $(this).data('url');
            $.get(userURL, function(data) {
                $('#contractorShowModal').modal('show');
                $('#c-id').text(data.id);
                $('#c-name').text(data.name);
                $('#c-email').text(data.email);
                $('#c-phoneNo').text(data.phoneNo);
                $('#c-companyName').text(data.companyName);
                $('#c-pass').text(data.passExpiryDate);
                $('#c-photo').attr('src', '/assets/' + data.passportPhoto);

                var link = '{{ route("checkin-contractor", ":id") }}';
                link = link.replace(':id', data.appointmentID);
                $('#c-link').attr('href', link);
                $('#c-text').text('Check-In'); // reset button text
            })
        });

    });
</script>
@endsection