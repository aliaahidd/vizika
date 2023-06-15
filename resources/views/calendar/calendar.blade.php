@extends('layouts.sideNav')
@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Calendar</h1>
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
    </style>
</head>

<body>
    <!-- <h1 class="header1">Calendar</h1> -->

    <div class="card">
        <div class="card-body">
            <div class="container">
                <div id='calendar'></div>
            </div>
        </div>
    </div>

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
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay',
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
                            var startTime = moment(event.start).format('hh:mm A');
                            var endTime = moment(event.end).format('hh:mm A');
                            var appointmentTime = startTime + ' - ' + endTime;

                            element.find('.fc-title').append('<div class="appointment-time">' + appointmentTime + '</div>');
                        }
                    }
                },

                events: {
                    url: "{{ route('calendar') }}",
                    type: 'GET',
                }

            });


        });
    </script>

</body>
@endsection