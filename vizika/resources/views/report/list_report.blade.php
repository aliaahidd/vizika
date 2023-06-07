@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Report</h1>
        <h6>Record List</h6>
    </div>
</div>

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
                searchPlaceholder: 'Search record'
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

<body>
    <!-- to display the alert message if the record has been deleted -->
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="get" action="{{ route('generatereport') }}">
                <div class="row">
                    <div class="col">
                        <label>Date Start:</label>
                        <input type="date" name="dateStart" class="form-control" onchange="setMinDate()">
                    </div>
                    <div class="col">
                        <label>Date End:</label>
                        <input type="date" name="dateEnd" class="form-control" id="dateEnd" min="">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col"><button class="btn btn-primary" style="float: right">Generate Report</button></div>
                </div>
            </form>
        </div>
    </div>
    <br>

    <div class="card">
        <div class="card-header pb-0">
            <div style="float: right; margin-bottom: 10px;">
                @if($exportData)
                <a href="{{ route('exportPDFAll', ['exportData' => $data]) }}" class="btn btn-primary"><i class="material-icons">print</i> Export PDF</a>
                <a href="{{ route('exportExcelAll', ['exportData' => $data]) }}" class="btn btn-primary"><i class="material-icons">print</i> Export Excel</a>
                @else
                <a href="{{ route('exportPDFGenerated', ['exportData' => $data, 'dateStart' => $dateStart, 'dateEnd' => $dateEnd]) }}" class="btn btn-primary"><i class="material-icons">print</i> Export PDF</a>
                <a href="{{ route('exportExcelGenerated', ['exportData' => $data, 'dateStart' => $dateStart, 'dateEnd' => $dateEnd]) }}" class="btn btn-primary"><i class="material-icons">print</i> Export Excel</a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="overflow-auto" style="overflow:hidden;">
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Visitor Name</th>
                                <th>KANEKA Staff</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Purpose</th>
                                <th>Agenda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportlist As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->cont_visit_name }}</td>
                                <td>{{ $data->staff_name }}</td>
                                <td>{{ $data->checkInDate }} {{ $data->checkInTime }} </td>
                                <td>{{ $data->checkOutDate }} {{ $data->checkOutTime }} </td>
                                <td>{{ $data->appointmentPurpose }}</td>
                                <td>{{ $data->appointmentAgenda }}</td>
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
@endsection

<script>
    function setMinDate() {
        const dateStartInput = document.querySelector('input[name="dateStart"]');
        const dateEndInput = document.querySelector('input[name="dateEnd"]');
        dateEndInput.min = dateStartInput.value;
    }
</script>