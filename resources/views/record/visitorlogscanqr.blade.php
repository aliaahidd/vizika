@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Visitor Log</h1>
        <h6>Visitor Log Scan QR</h6>
    </div>
</div>

<body>
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
                                <a class="nav-link {{ request()->routeIs('logvisitor') && !request()->has('type') ? 'active' : '' }}" href="{{ route('logvisitor') }}" role="tab" aria-selected="true">Appointment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('logvisitorqrcode') && !request()->has('type') ? 'active' : '' }}" href="{{ route('logvisitorqrcode') }}" role="tab" aria-selected="true">Scan QR</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="overflow-auto" style="overflow:hidden;">
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Purpose</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visitorlog As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->visitPurpose }}</td>
                                <td>{{ $data->checkInDate }} {{ $data->checkInTime }} </td>
                                <td>
                                    @if($data->checkOutTime == NULL)
                                    <div class="btn-group">
                                        <a class="btn btn-primary" style="color: white" href="{{ route('checkoutQR', $data->id) }}">Check Out</a>&nbsp
                                    </div>
                                    @else
                                    {{ $data->checkOutDate }} {{ $data->checkOutTime }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

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
                [1, "desc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search record'
            }
        });
    });
</script>
@endsection