@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Users</h1>
        <h6>List Blacklist</h6>
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
            <div class="{{ auth()->user()->category == 'SHEQ Officer' ? 'col-lg-12 col-md-12 col-sm-12' : (request()->routeIs('dashboard') ? 'col-lg-10 col-md-10 col-sm-10' : 'col-lg-12 col-md-12 col-sm-12') }}">
                <nav class="">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('userblacklist') && !request()->has('type') ? 'active' : '' }}" href="{{ route('userblacklist') }}" role="tab" aria-selected="true">List Of Visitor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->has('type') && request()->get('type') === 'contractor' ? 'active' : '' }}" href="{{ route('userblacklist', ['type' => 'contractor']) }}" role="tab" aria-selected="true">List Of Contractor</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="overflow-auto" style="overflow:auto;">
            <div class="table-responsive">
                @if(auth()->user()->category == 'SHEQ Officer')
                @if(request()->has('type') && request()->get('type') === 'contractor')
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Contractor ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Company</th>
                            <th>Pass Expiry Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blacklistcontractor as $key => $data)
                        <tr id="row{{ $data->id }}">
                            <td>{{ $data->contractorID }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->phoneNo }}</td>
                            <td>{{ $data->companyName }}</td>
                            <td>{{ $data->passExpiryDate }}</td>
                            <td>
                                <ul class="navbar-nav flex-row ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="d-none d-md-inline-block"><i class="large material-icons">more_vert</i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-small">
                                            <a class="dropdown-item text-danger" href="{{ route('profile-contractor', [$data->contractorID, 'from' => 'blacklist_users']) }}">
                                                <i class="material-icons text-danger">search</i> View
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Visitor ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Company</th>
                            <th>Occupation</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blacklistvisitor as $key => $data)
                        <tr id="row{{ $data->id }}">
                            <td>{{ $data->visitorID }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->phoneNo }}</td>
                            <td>{{ $data->companyName }}</td>
                            <td>{{ $data->occupation }}</td>
                            <td>
                                <ul class="navbar-nav flex-row ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="d-none d-md-inline-block"><i class="large material-icons">more_vert</i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-small">
                                            <a class="dropdown-item text-danger" href="{{ route('profile-visitor', [$data->visitorID, 'from' => 'balcklist_users']) }}">
                                                <i class="material-icons text-danger">search</i> View
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>


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
                searchPlaceholder: 'Search user'
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

@endsection