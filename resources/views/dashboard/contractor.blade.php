@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0 d-flex">
        <h1 class="page-title">Dashboard</h1>
    </div>
</div>

@if (session('success'))
<script>
    window.alert('{{ session("success") }}');
</script>
@endif

<!-- Dashboard information start -->
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div style="background-color: #ffc6c2; border-radius: 10px; display: flex; justify-content: center; align-items: center;">
                            <i class="material-icons md-48" style="font-size: 5rem; color: white; text-align: center">event</i>
                        </div>
                    </div>
                    <div class="col-8">
                        <h1>{{ $totalTodayAppt }}</h1>
                        <span>Today Appointment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div style="background-color: #fae9da; border-radius: 10px; display: flex; justify-content: center; align-items: center;">
                            <i class="material-icons md-48" style="font-size: 5rem; color: white; text-align: center">event</i>
                        </div>
                    </div>
                    <div class="col-8">
                        <h1>{{ $totalUpcomingAppt }}</h1>
                        <span>Total Upcoming Appointment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div style="background-color: #c3e0dd; border-radius: 10px; display: flex; justify-content: center; align-items: center;">
                            <i class="material-icons md-48" style="font-size: 5rem; color: white; text-align: center">event</i>
                        </div>
                    </div>
                    <div class="col-8">
                        <h1>{{ $totalPastAppt }}</h1>
                        <span>Total Past Appointment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<!-- Dashboard information end -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Today Appointment</h5>
            </div>
            <div class="card-body">
                <div class="overflow-auto" style="overflow:auto;">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Appointment Time</th>
                                    <th>KANEKA Staff</th>
                                    <th>Purpose</th>
                                    <th>Agenda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayAppointment As $key=>$data)
                                <tr id="row{{$data->id}}">
                                    <td>{{ $data->appointmentID }}</td>
                                    <td>{{ $data->appointmentTime }}</td>
                                    <td>{{ $data->staff_name }}</td>
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
    </div>
    <!-- <div class="col-4">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Total Visitor</h5>
            </div>
            <div class="card-body">
            </div>
        </div>
    </div> -->
</div>


@endsection
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Effort', 'Amount given'],
            ['My all', 50],
        ]);

        var options = {
            pieHole: 0.5,
            pieSliceTextStyle: {
                color: 'black',
            },
            legend: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('checkin_chart'));
        chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Effort', 'Amount given'],
            ['My all', 60],
        ]);

        var options = {
            pieHole: 0.5,
            pieSliceTextStyle: {
                color: 'black',
            },
            legend: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('checkout_chart'));
        chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Effort', 'Amount given'],
            ['My all', 65],
        ]);

        var options = {
            pieHole: 0.5,
            pieSliceTextStyle: {
                color: 'black',
            },
            legend: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('today_visitor'));
        chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Sales', 'Expenses'],
            ['2004', 1000, 400],
            ['2005', 1170, 460],
            ['2006', 660, 1120],
            ['2007', 1030, 540]
        ]);

        var options = {
            curveType: 'function',
            legend: {
                position: 'bottom'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('total_visitor_data'));

        chart.draw(data, options);
    }
</script>