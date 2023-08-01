@extends('layouts.sideNav')

@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Visitor & Contractor</h1>
        <h6>List Visitor & Contractor</h6>
    </div>
</div>



<!-- to display the alert message if the record has been deleted -->
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<div class="row mb-3 justify-content-end">
    <!-- if user == committee, then have add new appointment button  -->
    @if( auth()->user()->category=="Staff")
    <div class="col-lg-6 col-md-6 col-sm-6 d-flex justify-content-end">
        <a class="btn btn-primary mr-3" style="width:140px;" role="button" href="{{ route('bulkregistration') }}">
            <i class="fas fa-plus"></i>&nbsp; Bulk Registration</a>
        <a class="btn btn-primary" style="width:140px;" role="button" href="{{ route('registeruserform') }}">
            <i class="fas fa-plus"></i>&nbsp; User Registration</a>
    </div>
    @endif
</div>



<div class="card">
    <div class="card-header pb-0">
        <div class="row">
            <div class="{{ auth()->user()->category == 'Staff' ? 'col-lg-12 col-md-12 col-sm-12' : (request()->routeIs('dashboard') ? 'col-lg-10 col-md-10 col-sm-10' : 'col-lg-12 col-md-12 col-sm-12') }}">
                <nav class="">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('userlist') && !request()->has('type') ? 'active' : '' }}" href="{{ route('userlist') }}" role="tab" aria-selected="true">All user</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('registeredby') && !request()->has('type') ? 'active' : '' }}" href="{{ route('registeredby') }}" role="tab" aria-selected="true">Registered by me</a>
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
                @if( auth()->user()->category== "Staff")
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visitorlist As $key=>$data)
                        <tr id="row{{$data->id}}">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->category }}</td>
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
                searchPlaceholder: 'Search Visitor Contractor'
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