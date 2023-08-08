@extends('layouts.sideNav')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-header row no-gutters">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Contract</h1>
        <h6>List Contract</h6>
    </div>
</div>

@if( auth()->user()->category== "SHEQ Guard")
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

    <div class="row mb-3">
        <!-- <div class=" {{  auth()->user()->category== 'Staff' ? 'col-lg-10 col-md-10 col-sm-10' : (request()->routeIs('appointment') ? 'col-lg-10 col-md-10 col-sm-10' : 'col-lg-12 col-md-12 col-sm-12') }}">
                <nav class="">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointment') ? 'active' : '' }}" href="{{ route('appointment') }}" role="tab" aria-selected="true">Visitor Appointment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointment') ? 'active' : '' }}" href="{{ route('appointment/createappointment') }}" role="tab" aria-selected="true">Contractor Appointment</a>
                        </li>
                    </ul>
                </nav>
            </div> -->

        <!-- if user == committee, then have add new appointment button  -->
        @if( auth()->user()->category== "Staff")

        @if(request()->routeIs('contract'))
        <div class="col-lg-12 col-md-6 col-sm-3 justify-content-end d-flex">
            <a class="btn btn-primary" style="width:170px;" role="button" href="{{ route('contract/createcontract') }}">
                <i class="fas fa-plus"></i>&nbsp; Create Contract</a>
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
                    @if( auth()->user()->category== "Staff")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Contract Name</th>
                                <th>Date Start</th>
                                <th>Date End</th>
                                <th>Company Name</th>
                                <th>KANEKA PIC</th>
                                <th>Contract Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $count = 1; // Initialize a count variable
                            @endphp
                            @foreach($contractList As $key=>$data)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $data->contractName }}</td>
                                <td>{{ $data->contractStartDate }}</td>
                                <td>{{ $data->contractEndDate }}</td>
                                <td>{{ $data->companyName }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->contractAmount }}</td>
                                <td><a class="btn btn-primary" href="{{ route('contractdetails', $data->contractID) }}">View</a></td>
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
</body>
@endsection

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script>
    // to search the contract 
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [1, "desc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search contract'
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