@extends('layouts.sideNav')

<head>
    <style>
        #iconsDashboard {
            font-size: 40px;
            color: black;
            background-color: lightblue;
            padding: 20px;
            border-radius: 10%;
        }
    </style>
</head>
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0 d-flex">
        <h1 class="page-title">Dashboard</h1>
    </div>
</div>

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
                        <h1>{{ $totalAppointment }}</h1>
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
                        <h1>{{ $totalCheckIn }}</h1>
                        <span>Total Checkin</span>
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
                        <h1>{{ $totalCheckOut }}</h1>
                        <span>Total Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Dashboard information end -->

<div class="row">
    <div class="col-lg-9 col-md-6 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Total Visit for Past 7 Days</h5>
            </div>
            <div class="card-body">
                <div id="total_visitor_data" style="width: 100%; height: 100%"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <h5>User type</h5>
            </div>
            <div class="card-body">
                <div id="visitortype"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-6 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
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
                                    <th>Purpose</th>
                                    <th>Agenda</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($visitorlog As $key=>$data)
                                <tr id="row{{$data->id}}">
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->cont_visit_name }}</td>
                                    <td>{{ $data->staff_name }}</td>
                                    <td>{{ $data->appointmentPurpose }}</td>
                                    <td>{{ $data->appointmentAgenda }}</td>
                                    <td>{{ $data->checkInDate }} {{ $data->checkInTime }} </td>
                                    <td>{{ $data->checkOutDate }} {{ $data->checkOutTime }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
    });
</script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            ['Visitor', <?php echo $totalVisitor ?>],
            ['Contractor', <?php echo $totalContractor ?>],
        ]);

        var options = {
            // title: 'My Daily Activities'
            legend: {
                position: 'bottom'
            },
        };

        var chart = new google.visualization.PieChart(document.getElementById('visitortype'));

        chart.draw(data, options);
    }
</script>


<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var totalVisitLine = <?php echo json_encode($totalVisitLine); ?>;

        // Prepare the data for Google Charts
        var dataTable = [
            ['Date', 'Total Visit']
        ];
        for (var date in totalVisitLine) {
            var count = totalVisitLine[date];
            var formattedDate = date.substr(8, 2) + '/' + date.substr(5, 2);
            dataTable.push([formattedDate, count]);
        }

        var data = google.visualization.arrayToDataTable(dataTable);


        var options = {
            legend: {
                position: 'bottom'
            },
            curveType: 'none',
            hAxis: {
                format: 'dd/MM'
            },
            vAxis: {
                format: '0'
            }, // Set the format to display integers
            series: {
                0: {
                    curveType: 'none'
                }
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('total_visitor_data'));
        chart.draw(data, options);
    }

    function getPastDateString(today, daysAgo) {
        var pastDate = new Date(today);
        pastDate.setDate(today.getDate() - daysAgo);
        var year = pastDate.getFullYear().toString().slice(-2); // Get the last two digits of the year
        var month = padZero(pastDate.getMonth() + 1);
        var day = padZero(pastDate.getDate());
        return day + '/' + month + '/' + year;
    }

    function padZero(number) {
        return (number < 10 ? '0' : '') + number;
    }
</script>