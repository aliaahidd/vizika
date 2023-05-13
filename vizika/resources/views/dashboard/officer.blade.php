@extends('layouts.sideNav')
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
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">person</i>
                    </div>
                    <div class="col-8">
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
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">person</i>
                    </div>
                    <div class="col-8">
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
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">event</i>
                    </div>
                    <div class="col-8">
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
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">event</i>
                    </div>
                    <div class="col-8">
                        <h1>25</h1>
                        <span>Total Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<!-- Dashboard information end -->

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Total Visitor</h5>
            </div>
            <div class="card-body">
                <div id="checkin_chart" style="width: 175px; height: 200px; float: left"></div>
                <div id="checkout_chart" style="width: 175px; height: 200px; float: left"></div>
                <div id="today_visitor" style="width: 175px; height: 200px; float: left"></div>

            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Total Visitor</h5>
            </div>
            <div class="card-body">
                <div id="total_visitor_data" style="width: 520px; height: 200px"></div>
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