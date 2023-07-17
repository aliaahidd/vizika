@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Visitor & Contractor</h1>
        <h6><a href="{{ route('registeredby') }}">List Visitor & Contractor (Registered by me) </a>/ Profile</h6>
    </div>
</div>

@if($usertype->category == "Visitor")
<!-- display all from registration -->
<div class="row justify-content-center">
    <div class="col-md-3 mb-3">
        <div class="card" style="padding: 20px; height: 400px">
            <div style="margin: auto;">
                <img src="/assets/{{$visitor->name}}/{{$visitor->facialRecognition}}" width="200px">
            </div>
        </div>
    </div>
    <div class="col-md-9 mb-3">
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

@if( $visitor->status == 'Pending' )
<div class="row justify-content-end">
    <div class="col-md-12">
        <a href="{{ route('approveuser', $visitor->userID) }}" class="btn btn-success" style="float: right;">Approve</a>
    </div>
</div>
@endif

@elseif($usertype->category == "Contractor")
<!-- display all from registration -->
<div class="row justify-content-center">
    <div class="col-md-3 mb-3">
        <div class="card" style="padding: 20px; height: 450px">
            <div class="col-12">
                <h5>Passport Photo</h5>
                <hr>
                <div style="margin: auto;">
                    <img src="/assets/{{$contractor->name}}/{{$contractor->facialRecognition}}" width="200px">
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
                        <label for="name">{{ $contractor->name }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="email">Email</label>
                    </div>
                    <div class="col">
                        <label for="email">{{ $contractor->email }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="email">Phone Number</label>
                    </div>
                    <div class="col">
                        <label for="email">{{ $contractor->phoneNo }}</label>
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
                        <label for="companyName">{{ $contractor->companyName }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="employeeNo">Employee Number</label>
                    </div>
                    <div class="col">
                        <label for="employeeNo">{{ $contractor->employeeNo }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="expiryPass">Pass Expiry Date</label>
                    </div>
                    <div class="col">
                        <label for="expiryPass">{{ $contractor->passExpiryDate }} <a data-toggle="modal" data-target="#viewPassModal" style="color: blue;" id="viewPass">View Pass</a></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="address">Address</label>
                    </div>
                    <div class="col">
                        <label for="address">{{ $contractor->address }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="birthdate">Birth Date</label>
                    </div>
                    <div class="col">
                        <label for="birthdate">{{ $contractor->birthDate }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if( $contractor->status == 'Pending' )
<div class="row justify-content-end">
    <div class="col-md-12">
        <a href="{{ route('approveuser', $contractor->userID) }}" class="btn btn-success" style="float: right;">Approve</a>
    </div>
</div>
@endif

<div class="modal fade" id="viewPassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Validity Pass Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="justify-content-center text-center">
                    <img src="/assets/pass/{{$contractor->validityPassPhoto}}" width="400px">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endif
<br>


<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
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

@endsection