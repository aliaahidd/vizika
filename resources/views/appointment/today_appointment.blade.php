@extends('layouts.sideNav')

@section('content')
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

<body>
    <!-- to display the alert message if the record has been deleted -->
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <!-- Page Header -->
    <div class="page-header row no-gutters pb-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0 d-flex">
            <h1 class="page-title">Profile</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            @if($usertype->category == 'Contractor')
            <a href="{{ route('scanBiometric', $usertype->appointmentID) }}" class="btn btn-primary" style="color: white; float: right">Scan Face</a>
            @elseif($usertype->category == 'Visitor')
            <a href="{{ route('scanBiometric', $usertype->appointmentID) }}" class="btn btn-primary" style="color: white; float: right">Scan Face</a>
            @endif
        </div>
    </div>
    <br>
    <!-- display all from registration -->
    <div class="row justify-content-center">
        @if ($usertype->category == 'Contractor')
        <div class="col-md-3">
            <div class="card" style="padding: 20px; height: 450px">
                <div class=" col-12">
                    <h5>Photo</h5>
                    <hr>
                    <div style="margin: auto;">
                        <img src="/assets/{{$usertype->name}}/{{$usertype->facialRecognition}}" width="200px">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card" style="padding: 20px; height: 450px">
                <div class=" col-12">
                    <h5>Contact Details</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="name">Name</label>
                        </div>
                        <div class="col">
                            <label for="name">{{ $usertype->name }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $usertype->email }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Phone Number</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $usertype->phoneNo }}</label>
                        </div>
                    </div>
                    <br>

                    <h5>Additional Information</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="companyName">Company Name</label>
                        </div>
                        <div class="col">
                            <label for="companyName">{{ $usertype->companyName }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="employeeNo">Employee Number</label>
                        </div>
                        <div class="col">
                            <label for="employeeNo">{{ $usertype->employeeNo }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="employeeNo">Pass Expiry Date</label>
                        </div>
                        <div class="col">
                            <label for="employeeNo">{{ $usertype->passExpiryDate }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="address">Address</label>
                        </div>
                        <div class="col">
                            <label for="address">{{ $usertype->address }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="birthdate">Birth Date</label>
                        </div>
                        <div class="col">
                            <label for="birthdate">{{ $usertype->birthDate }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif ($usertype->category == 'Visitor')
        <div class="col-md-3">
            <div class="card" style="padding: 20px; height: 400px">
                <div style="margin: auto;">
                    <img src="/assets/{{$usertype->name}}/{{$usertype->facialRecognition}}" width="200px">
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card" style="padding: 20px; height: 400px">
                <div class=" col-12">
                    <h5>Contact Details</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="name">Name</label>
                        </div>
                        <div class="col">
                            <label for="name">{{ $usertype->name }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $usertype->email }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Phone Number</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $usertype->phoneNo }}</label>
                        </div>
                    </div>
                    <br>

                    <h5>Additional Information</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="address">Address</label>
                        </div>
                        <div class="col">
                            <label for="address">{{ $usertype->address }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="birthdate">Birth Date</label>
                        </div>
                        <div class="col">
                            <label for="birthdate">{{ $usertype->birthDate }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="employeeNo">Employee ID</label>
                        </div>
                        <div class="col">
                            <label for="employeeNo">{{ $usertype->employeeNo }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="occupation">Occupation</label>
                        </div>
                        <div class="col">
                            <label for="occupation">{{ $usertype->occupation }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

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