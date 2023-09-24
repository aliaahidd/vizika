@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-6 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Safety Briefing</h1>
        <h6>Briefing Slot</h6>
        <h6>List below shows 30 days of safety briefing slot from current date.</h6>
    </div>
</div>

<body>
    <!-- to display the alert message if the record has been added -->
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header pb-0">

        </div>

        <div class="card-body">
            <div class="overflow-auto" style="overflow:hidden;">
                <div class="table-responsive">
                    @if( auth()->user()->category== "SHEQ Officer")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Time Start</th>
                                <th>Time End</th>
                                <th>Max Participant</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($briefingSlot As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->briefingDate }}</td>
                                <td>{{ $data->briefingTimeStart }}</td>
                                <td>{{ $data->briefingTimeEnd }}</td>
                                <td>{{ $data->maxParticipant }}</td>
                                <td> @if ($data->briefingStatus == "Active")
                                    <div style="background-color: #d9f3ea; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto;">
                                        <label style="color: #0bb37a; text-align: center; font-weight: bold" class="mb-1 mt-1">Active</label>
                                    </div>
                                    @else
                                    <div style="background-color: #ffe6e6; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto;">
                                        <label style="color: #ff5b5b; text-align: center; font-weight: bold" class="mb-1 mt-1">Cancelled</label>
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('editbriefing', $data->id )}}" class="btn btn-primary" style="justify-content: center; align-items: center; margin: auto; color: white">Edit</a>
                                    <a href="{{ route('cancelsession', $data->id )}}" class="btn btn-danger" style="justify-content: center; align-items: center; margin: auto; color: white">Cancel</a>
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
                [1, "desc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search briefing'
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