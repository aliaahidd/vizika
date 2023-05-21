@extends('layouts.sideNav')

@section('content')
<h4>Visitor List</h4>
<h6>Active Visitor List</h6>

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
                searchPlaceholder: 'Search visitor'
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
    </div>

    <div class="card-body">
        <div class="overflow-auto" style="overflow:auto;">
            <div class="table-responsive">
                <!-- FOR OFFICER TO VIEW RECORD APPOINTMENT LIST START -->
                @if( auth()->user()->category== "SHEQ Officer")
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Company</th>
                            <th>Occupation</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visitorlist As $key=>$data)
                        <tr id="row{{$data->id}}">
                            <td>{{ $data->employeeID }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->phoneNo }}</td>
                            <td>{{ $data->companyName }}</td>
                            <td>{{ $data->occupation }}</td>
                            <td>
                                <ul class="navbar-nav flex-row ml-auto ">
                                    <li class="nav-item">
                                        <a class="nav-link text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="d-none d-md-inline-block"><i class="large material-icons">more_vert</i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-small">
                                            <a class="dropdown-item text-danger" href="{{ route('profile-visitor', [$data->userID, 'from' => 'active_users']) }}">
                                                <i class="material-icons text-danger">search</i> View </a>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <!-- FOR OFFICER TO VIEW RECORD APPOINTNMENT LIST END -->
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>

@endsection