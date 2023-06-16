@extends('layouts.sideNav')

@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Company</h1>
        <h6>Company List</h6>
    </div>
</div>

<!-- to display the alert message if the record has been deleted -->
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<div class="row mb-3">

    <!-- if user == committee, then have add new appointment button  -->
    @if( auth()->user()->category== "SHEQ Officer")

    @if(request()->routeIs('company'))
    <div class="col-lg-12 col-md-12 col-sm-12 justify-content-end d-flex">
        <a class="btn btn-primary" style="width:170px;" role="button" href="{{ route('createcompany') }}">
            <i class="fas fa-plus"></i>&nbsp; Create Company</a>
    </div>
    @else
    <div class="col-lg-12 col-md-12 col-sm-12" style="float: right;">
        <a class="btn btn-success" style="float: right; width:100%;" role="button" href="">
            <i class="fa fa-cog"></i>&nbsp; -</a>
    </div>
    @endif

    @endif

</div>

<div class="card">
    <div class="card-header pb-0">
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
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companylist As $key=>$data)
                        <tr id="row{{$data->id}}">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->companyName }}</td>
                            <td>{{ $data->companyEmail }}</td>
                            <td>{{ $data->companyPhoneNo }}</td>
                            <td>{{ $data->companyAddress }}</td>
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
                [0, "asc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search company'
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