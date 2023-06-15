@extends('layouts.sideNav')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Appointment</h1>
        <h6>List Appointment</h6>
    </div>
</div>
@if( auth()->user()->category== "SHEQ Guard" || auth()->user()->category== "SHEQ Officer")
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

    <div class="card">
        <div class="card-header pb-0">
            <div class="row">

            </div>
        </div>

        <div class="card-body">
            <div class="overflow-auto" style="overflow:auto;">
                <div class="table-responsive">
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
                                <td>{{ $data->appointmentID }}</td>
                                <td>{{ $data->cont_visit_name }}</td>
                                <td>{{ $data->staff_name }}</td>
                                <td>{{ $data->appointmentPurpose }}</td>

                                @if( $data->category == "Visitor")
                                <td><a class="btn btn-primary" style="color: white" href="{{ route('visitor.showV', $data->appointmentID) }}">View</a>
                                    @elseif( $data->category == "Contractor")
                                <td><a class="btn btn-primary" style="color: white" href="{{ route('contractor.showC', $data->appointmentID) }}">View</a>
                                </td>
                                @endif

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    <!-- FOR OFFICER TO VIEW RECORD APPOINTNMENT LIST END -->

                    @if( auth()->user()->category== "SHEQ Officer")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Visitor Name</th>
                                <th>KANEKA Staff</th>
                                <th>Purpose</th>
                                <th>Appointment Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointmentGuard As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->appointmentID }}</td>
                                <td>{{ $data->cont_visit_name }}</td>
                                <td>{{ $data->staff_name }}</td>
                                <td>{{ $data->appointmentPurpose }}</td>
                                <td>{{ $data->appointmentTime }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    <!-- FOR OFFICER TO VIEW RECORD APPOINTNMENT LIST END -->
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
                    <form method="post" action="{{ route('checkinuser', ':id') }}" id="contractor-form">
                        @csrf
                        @method('post')
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
                                    <div class="row">
                                        <div class="col-5">
                                            <label>Pass Number</label>
                                        </div>
                                        <div class="col">
                                            <label><input type="text" name="passNoV" id="passNoV" class="form-control" required></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="v-link" class="btn btn-primary" data-bs-dismiss="modal"><span id="v-text">Check-in</span></button>
                            <div id="v-id" style="display: none"></div>
                        </div>
                    </form>
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
                    <form method="post" action="{{ route('checkinuser', ':id') }}" id="visitor-form">
                        @csrf
                        @method('post')
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
                                    <div class="row">
                                        <div class="col-5">
                                            <label>Pass Number</label>
                                        </div>
                                        <div class="col">
                                            <label><input type="text" name="passNoC" id="passNoC" class="form-control" required></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="c-link" class="btn btn-primary" data-bs-dismiss="modal"><span id="c-text">Check-in</span></button>
                            <div id="c-id" style="display: none"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                $('#v-photo').attr('src', '/assets/avatar/' + data.passportPhoto);

                var link = '{{ route("checkinuser", ":id") }}';
                link = link.replace(':id', data.appointmentID);
                $('#v-link').attr('href', link);
                $('#v-link').attr('data-appointment-id', data.appointmentID);
                $('#v-text').text('Check-In');
            })
        });

        $('body').on('click', '#v-link', function(event) {
            event.preventDefault(); // prevent the default behavior of the link

            // get the pass number input value
            var passNumber = $('#passNoV').val();

            // check if the pass number is empty or not
            if (!passNumber) {
                alert('Please enter a pass number');
                return false;
            }

            var appointmentID = $('#v-link').attr('data-appointment-id');
            var formAction = "{{ route('checkinuser', ':id') }}";
            formAction = formAction.replace(':id', appointmentID);
            $('#visitor-form').attr('action', formAction);
            // create a hidden input element dynamically
            var passNumberInput = $('<input>').attr({
                type: 'hidden',
                name: 'passNoV',
                value: passNumber
            });

            // append the hidden input to the form
            $('#visitor-form').append(passNumberInput);

            // update the form action and submit the form
            $('#visitor-form').attr('action', formAction).submit();
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $('body').on('click', '#show-contractor', function() {
            var userURL = $(this).data('url');
            $.get(userURL, function(data) {
                $('#contractorShowModal').modal('show');
                $('#c-id').text(data.appointmentID);
                $('#c-id').attr('data-appointment-id', data.appointmentID);
                $('#c-name').text(data.name);
                $('#c-email').text(data.email);
                $('#c-phoneNo').text(data.phoneNo);
                $('#c-companyName').text(data.companyName);
                $('#c-pass').text(data.passExpiryDate);
                $('#c-photo').attr('src', '/assets/avatar/' + data.passportPhoto);

                var link = '{{ route("checkinuser", ":id") }}';
                link = link.replace(':id', data.appointmentID);
                $('#c-link').attr('href', link);
                $('#c-link').attr('data-appointment-id', data.appointmentID);
                $('#c-text').text('Check-In');
            })
        });


        $('body').on('click', '#c-link', function(event) {
            event.preventDefault(); // prevent the default behavior of the link

            // get the pass number input value
            var passNumber = $('#passNoC').val();

            // check if the pass number is empty or not
            if (!passNumber) {
                alert('Please enter a pass number');
                return false;
            }

            var appointmentID = $('#c-link').attr('data-appointment-id');
            var formAction = "{{ route('checkinuser', ':id') }}";
            formAction = formAction.replace(':id', appointmentID);
            $('#contractor-form').attr('action', formAction);
            // create a hidden input element dynamically
            var passNumberInput = $('<input>').attr({
                type: 'hidden',
                name: 'passNoC',
                value: passNumber
            });

            // append the hidden input to the form
            $('#contractor-form').append(passNumberInput);

            // update the form action and submit the form
            $('#contractor-form').attr('action', formAction).submit();
        });
    });
</script>
@endsection