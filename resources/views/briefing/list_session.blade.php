@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Safety Briefing</h1>
        <h6><a href="{{ route('briefing') }}">List Briefing </a> /
            <a>List Participant</a>
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

    <div class="card">
        <div class="card-header pb-0">
            <h6>Date : {{$briefinginfo->briefingDate}}</h6>
            <h6>Time : {{$briefinginfo->briefingTimeStart}} - {{$briefinginfo->briefingTimeEnd}}</h6>
        </div>

        <div class="card-body">
            <div class="overflow-auto" style="overflow:hidden;">
                <div class="table-responsive">
                    @if( auth()->user()->category== "SHEQ Officer")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessionlist As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->contractorID }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->phoneNo }}</td>
                                <td>{{ $data->email }}</td>
                                <td>
                                    <a class="btn btn-success" style="color: white" href="{{ route('updatepassdate', $data->id) }}">Attend</a>&nbsp
                                    <a class="btn btn-danger" style="color: white" href="{{ route('deleterecord', $data->id) }}">Not Attend</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
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
                [0, "asc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search name'
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