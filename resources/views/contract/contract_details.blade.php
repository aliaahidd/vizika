@extends('layouts.sideNav')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header row no-gutters">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Contract</h1>
        <h6><a href="{{ route('contract') }}">List Contract </a> /
            <a>Contract Details</a>
        </h6>
    </div>
</div>

<body>
    <!-- to display the alert message if the record has been deleted -->
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <div class="row mb-3">

        @if( auth()->user()->category== "SHEQ Guard")

        @if(request()->routeIs('contractortransport'))
        <div class="col-lg-12 col-md-6 col-sm-3 justify-content-end d-flex">
            <a class="btn btn-primary" style="width:170px;" role="button" href="{{ route('contractortransport/registerTransport') }}">
                <i class="fas fa-plus"></i>&nbsp; Register Transport</a>
        </div>
        @endif

        @endif

    </div>
    <div class="card">
        <div class="card-header pb-0">

        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <label>Company</label>
                </div>
                <div class="col-md-10">
                    <h6>{{$contract->companyName}}</h6>
                </div>
                <div class="col-md-2">
                    <label>Contract Name</label>
                </div>
                <div class="col-md-10">
                    <h6>{{$contract->contractName}}</h6>
                </div>
                <div class="col-md-2">
                    <label>Contract Start Date</label>
                </div>
                <div class="col-md-10">
                    <h6>{{$contract->contractStartDate}}</h6>
                </div>
                <div class="col-md-2">
                    <label>Contract End Date</label>
                </div>
                <div class="col-md-10">
                    <h6>{{$contract->contractEndDate}}</h6>
                </div>
                <div class="col-md-2">
                    <label>Contract Amount</label>
                </div>
                <div class="col-md-10">
                    <h6>{{$contract->contractAmount}}</h6>
                </div>
            </div>
            <div class="overflow-auto" style="overflow:auto;">
                <div class="table-responsive">
                    <!-- FOR SHEQ GUARD TO VIEW TRANSPORT LIST START -->
                    @if( auth()->user()->category== "Staff")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Employee No</th>
                                <th>Pass Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $count = 1; // Initialize a count variable
                            @endphp
                            @foreach($contractorInfo As $key=>$data)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->employeeNo }}</td>
                                <td>{{ $data->passExpiryDate }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @endif
                    <!-- FOR SHEQ GUARD TO VIEW TRANSPORT LIST END -->
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#view-button').on('click', function() {
            var id = $(this).data('id');
            // Now you can use the 'id' variable to perform any action, like opening a modal or redirecting to a new page with the ID parameter.
            // For example, you can show the details of the contractor based on this ID.
            // You might make an AJAX request to fetch the contractor details and display them in a modal or another part of the page.
            console.log('Clicked ID:', id);
        });
    });
</script>