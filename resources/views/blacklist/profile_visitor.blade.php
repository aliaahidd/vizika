@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">User</h1>
        @if(request()->query('from') == 'active_users')
        <h6><a href="{{ route('useractive') }}">Active User</a> /
            @elseif(request()->query('from') == 'blacklist_users')
            <h6><a href="{{ route('userblacklist') }}">Blacklist User</a> /
                @endif
                <a>Profile Visitor</a>
            </h6>
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

<div class="row justify-content-center">
    <div class="col">
        @if(request()->query('from') == 'active_users')
        <a class="btn btn-danger" style="color: white; float: right" id="blacklistBtn" data-toggle="modal" data-target="#yourModal"><i class="material-icons">block</i> Blacklist</a>
        @elseif(request()->query('from') == 'blacklist_users')
        <a class="btn btn-success" style="color: white; float: right" id="unblacklistBtn" href="{{ route('unblacklist', $visitor->userID) }}"><i class="material-icons">block</i> Unblacklist</a>
        @endif
    </div>
</div>
<br>
<!-- display all from registration -->
<div class="row justify-content-center">
    <div class="col-md-3 mb-3">
        <div class="card" style="padding: 20px; height: 400px">
            <div style="margin: auto;">
                <img src="/assets/{{$visitor->name}}/{{$visitor->passportPhoto}}" width="200px">
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
                        <label for="name">{{ $visitor->name }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="email">Email</label>
                    </div>
                    <div class="col">
                        <label for="email">{{ $visitor->email }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="email">Phone Number</label>
                    </div>
                    <div class="col">
                        <label for="email">{{ $visitor->phoneNo }}</label>
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
                        <label for="address">{{ $visitor->address }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="birthdate">Birth Date</label>
                    </div>
                    <div class="col">
                        <label for="birthdate">{{ $visitor->birthDate }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="employeeNo">Employee ID</label>
                    </div>
                    <div class="col">
                        <label for="employeeNo">{{ $visitor->employeeNo }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="occupation">Occupation</label>
                    </div>
                    <div class="col">
                        <label for="occupation">{{ $visitor->occupation }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<div class="row justify-content-center">
    <div class=" col-12">
        <div class="card" style="padding: 20px;">
            <div class=" table-responsive">
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
                        @foreach($pastrecord As $key=>$data)
                        <tr id="row{{$data->id}}">
                            <td>{{ $data->recordID }}</td>
                            <td>{{ $data->cont_visit_name }}</td>
                            <td>{{ $data->staff_name }}</td>
                            <td>{{ $data->appointmentPurpose }}</td>
                            <td>{{ $data->appointmentAgenda }}</td>
                            <td>{{ $data->checkInDate }} {{ $data->checkInTime }} </td>
                            <td>{{ $data->checkOutDate }} {{ $data->checkOutTime }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
    <!-- MODAL BOX -->
    <!-- To display the modal box if reject button is clicked to enter the feedback comment -->
    <div class="modal fade" id="yourModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Blacklist Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="post" action="{{ route('blacklist', $visitor->userID) }}">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <textarea type="text" class="form-control" name="blacklistReason" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            $('body').on('click', '#submitBtn', function(event) {
                event.preventDefault(); // prevent the default behavior of the link

                // get the pass number input value
                var passNumber = $('#passNo').val();

                // check if the pass number is empty or not
                if (!passNumber) {
                    alert('Please enter a pass number');
                    return false;
                }

                var appointmentID = $('#v-link').attr('data-appointment-id');
                var formAction = "{{ route('checkinuser', ':id') }}";
                formAction = formAction.replace(':id', appointmentID);
                $('form').attr('action', formAction);

                $('form').submit();
            });
        });
    </script>

    @endsection