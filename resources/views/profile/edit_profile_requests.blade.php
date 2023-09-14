@extends('layouts.sideNav')

@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Edit Profile Approval</h1>
        <h6>Edit Profile Approval Request List</h6>
    </div>
</div>



<!-- to display the alert message if the record has been deleted -->
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<div class="card">
    <div class="card-header pb-0">
        <div class="row">
            <div class="{{ auth()->user()->category == 'Staff' ? 'col-lg-12 col-md-12 col-sm-12' : (request()->routeIs('dashboard') ? 'col-lg-10 col-md-10 col-sm-10' : 'col-lg-12 col-md-12 col-sm-12') }}">
                <nav class="">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('registeredby') && !request()->has('type') ? 'active' : '' }}" href="{{ route('registeredby') }}" role="tab" aria-selected="true">Waiting Approval</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="overflow-auto" style="overflow:auto;">
            <div class="table-responsive">
                <!-- FOR STAFF TO VIEW RECORD APPOINTMENT LIST START -->
                @if( auth()->user()->category== "SHEQ Officer")
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Field Changed</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                            <th>Request Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($changerequests As $key=>$data)
                        <tr id="row{{$data->id}}">
                            <td>{{ $data->sessionID }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->companyName }}</td>
                            <td>{{ $data->field_changed }}</td>
                            <td>{{ $data->original_value }}</td>
                            <td>{{ $data->new_value }}</td>
                            <td>{{ $data->requestStatus }}</td>

                            @if( $data->status == 'Registered')
                            <td><button class="btn btn-primary" disabled>View</button></td>
                            @else
                            <td class="text-center">
                                <a class="btn btn-primary" href="{{ route('registeredprofile', [$data->sessionID]) }}">View</a>
                                <a href="{{ route('approvechangerequests', [$data->changeRequestID]) }}" class="btn btn-success">Approve</a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif
                <!-- FOR STAFF TO VIEW RECORD APPOINTNMENT LIST END -->
            </div>
        </div>
    </div>
</div>


</div>

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script>
    // to search the visitor contractor 
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [1, "asc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search name'
            }
        });

        // filter visitor contractor 
        $('.dataTables_filter input[type="search"]').css({
            'width': '300px',
            'display': 'inline-block',
            'font-size': '15px',
            'font-weight': '400'
        });
    });
</script>
<Script>

</script>
@endsection