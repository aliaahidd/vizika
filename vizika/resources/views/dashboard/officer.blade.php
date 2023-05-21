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
        <h1 class="page-title ml-3">Dashboard</h1>
    </div>
</div>

<!-- Dashboard information start -->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <i class="material-icons md-48" id="iconsDashboard" style="background-color:lightblue">person</i>
                    </div>
                    <div class="col-7">
                        <h1>{{ $totalVisitor }}</h1>
                        <span>Total Visitor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <i class="material-icons md-48" id="iconsDashboard" style="background-color:lightblue">person</i>
                    </div>
                    <div class="col-7">
                        <h1>{{ $totalContractor }}</h1>
                        <span>Total Contractor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <i class="material-icons md-48" id="iconsDashboard" style="background-color:lightblue">event</i>
                    </div>
                    <div class="col-7">
                        <h1>{{$totalTodayAppointment}}</h1>
                        <span>Today's Appt.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <i class="material-icons md-48" id="iconsDashboard" style="background-color:lightblue">event</i>
                    </div>
                    <div class="col-7">
                        <h1>{{ $totalVisitRecord }}</h1>
                        <span>Total Visit</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<!-- Dashboard information end -->

<div class="row">
    <div class="col-9">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Total Visit</h5>
            </div>
            <div class="card-body">
                <div id="total_visitor_data" style="width: 100%; height: 100%"></div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Total Visitor</h5>
            </div>
            <div class="card-body">
                <div id="visitortype"></div>

            </div>
        </div>
    </div>
</div>


@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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