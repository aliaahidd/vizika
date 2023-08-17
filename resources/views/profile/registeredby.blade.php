@extends('layouts.sideNav')

@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Registration Approval</h1>
        <h6>Registration Approval List</h6>
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
            <div class="mb-3">
                <a href="{{ route('approveallregistration') }}" class="btn btn-success" style="float: right;">Approve all</a>
            </div>
            <div class="table-responsive">
                <!-- FOR STAFF TO VIEW RECORD APPOINTMENT LIST START -->
                @if( auth()->user()->category== "SHEQ Officer")
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visitorlist As $key=>$data)
                        <tr id="row{{$data->id}}">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->category }}</td>
                            @if( $data->status == 'Registered')
                            <td>
                                <div style="background-color: #dff0fa; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto; width: 100px">
                                    <label style=" color: #2d9cdb; text-align: center; font-weight: bold" class="mb-1 mt-1">{{ $data->status }}</label>
                                </div>
                            </td>
                            @elseif( $data->status == 'Pending')
                            <td>
                                <div style="background-color: #fef6d9; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto; width: 100px">
                                    <label style=" color: #f2c204; text-align: center; font-weight: bold" class="mb-1 mt-1">{{ $data->status }}</label>
                                </div>
                            </td>
                            @elseif( $data->status == 'Active')
                            <td>
                                <div style="background-color: #d9f3ea; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto; width: 100px">
                                    <label style=" color: #0bb37a; text-align: center; font-weight: bold" class="mb-1 mt-1">{{ $data->status }}</label>
                                </div>
                            </td>
                            @endif
                            @if( $data->status == 'Registered')
                            <td><button class="btn btn-primary" disabled>View</button></td>
                            @else
                            <td class="text-center">
                                <a class="btn btn-primary" href="{{ route('registeredprofile', [$data->id]) }}">View</a>
                                <a href="{{ route('approveuser', [$data->id]) }}" class="btn btn-success">Approve</a>
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