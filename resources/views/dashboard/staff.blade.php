@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0 d-flex">
        <h1 class="page-title">Dashboard</h1>
    </div>
</div>

<head>
    <title>Laravel Fullcalender Tutorial Tutorial - ItSolutionStuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        .header1 {
            margin-bottom: 0.75rem;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 400;
            color: #3d5170;
        }

        .fc-event {
            background-color: #007bff;
        }

        .fc-title,
        .fc-time {
            color: white;
        }

        /* Adjust the calendar size */
        .container {
            padding-right: 0px;
            padding-left: 0px;
            /* Change this value as needed */
            margin: 0 auto;
        }

        .fc-day-header {
            width: 10px;
            /* Adjust this value as needed */
        }

        .fc table {
            font-size: 12px;
        }

        h2 {
            font-size: 20px;
        }
    </style>
</head>

<!-- Dashboard information start -->
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div style="border-radius: 10px; display: flex; justify-content: center; align-items: center;">
                            <i class="material-icons md-48" style="font-size: 5rem; color: white; text-align: center; color: #6497b1; ">event</i>
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
                        <div style="border-radius: 10px; display: flex; justify-content: center; align-items: center;">
                            <i class="material-icons md-48" style="font-size: 5rem; color: white; text-align: center; color: #005b96;">event</i>
                        </div>
                    </div>
                    <div class="col-8">
                        <h1>{{ $totalUpcomingAppt }}</h1>
                        <span>Total Tomorrow Appointment</span>
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
                        <div style="border-radius: 10px; display: flex; justify-content: center; align-items: center;">
                            <i class="material-icons md-48" style="font-size: 5rem; color: white; text-align: center; color: #04427d; ">event</i>
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
<!-- Dashboard information end -->

<div class="row">
    <div class="col-lg-8 col-md-6 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Total Visit for Past 7 Days</h5>
            </div>
            <div class="card-body">
                <div id="total_visitor_data" style="width: 100%; height: 100%; min-height: 240px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card">
            <div class="card-body" style="height: 100%">
                <div class="container">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                                    <th>Visitor Name</th>
                                    <th>Purpose</th>
                                    <th>Agenda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayAppointment As $key=>$data)
                                <tr id="row{{$data->id}}">
                                    <td>{{ $data->appointmentID }}</td>
                                    <td>{{ $data->appointmentTime }}</td>
                                    <td>{{ $data->cont_visit_name }}</td>
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
            },
            chartArea: {
                width: '90%', // Adjust the chart area width
                height: '70%' // Adjust the chart area height
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('total_visitor_data'));
        // Redraw the chart when the window is resized
        $(window).resize(function() {
            chart.draw(data, options);
        });

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

<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({
            editable: false,
            firstDay: 1,

            header: {
                left: '',
                center: 'title',
                right: '',
            },

            views: {
                agendaDay: {
                    type: 'agenda',
                    duration: {
                        days: 1
                    },
                    buttonText: 'Day',
                    titleFormat: 'MMMM D, YYYY',
                    columnFormat: 'dddd',
                    columnHeaderFormat: 'ddd, MMM D',
                    slotLabelFormat: 'hh:mm A',
                    slotDuration: '00:30:00',
                    allDaySlot: false,
                    nowIndicator: true,
                    eventLimit: true,
                    eventRender: function(event, element) {
                        var hasData = event.hasData; // Assuming you have a property indicating if the event has data

                        if (hasData) {
                            element.find('.fc-title').html('<div class="badge badge-primary">Data Available</div>');
                        }
                    }
                }
            },

            events: {
                url: "{{ route('calendarstaff') }}",
                type: 'GET',
            }

        });


    });
</script>