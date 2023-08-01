@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Briefing</h1>
        <h6><a href="{{ route('briefing') }}">List Briefing </a> /
            <a>Create New Briefing</a>
        </h6>
    </div>
</div>

<!-- message box if the new briefing has been added -->
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <!-- form create new briefing -->
        <form method="POST" action="{{ route('storebriefinginfo') }}" enctype="multipart/form-data" id="briefing">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label>Date<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="date" name="briefingDate" class="form-control" id="txtDate" required>
                    <br>
                    <label>Time end<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="time" name="briefingTimeEnd" class="form-control" id="endTimeInput" required>
                </div>

                <div class="col-md-6">
                    <label>Time Start<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="time" name="briefingTimeStart" class="form-control" id="timeInput" required>
                    <br>
                    <label>Max Participant<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="number" name="participantNo" class="form-control" placeholder="Ex: 30" required>
                </div>
            </div>
            <div class="row justify-content-end">
                <a href="javascript:history.go(-1)" class="btn btn-danger pull-right mr-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js'></script>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- to avoid user choose the past date -->
<script>
    // get the current date
    var today = new Date();

    // add 3 days to the current date
    var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 4);

    // convert the date to ISO format
    var minDateISO = minDate.toISOString().slice(0, 10);

    // set the minimum value of the date input field
    document.getElementById("txtDate").setAttribute("min", minDateISO);

    const dateInput = document.getElementById("txtDate");

    dateInput.addEventListener("input", () => {
        const chosenDate = new Date(dateInput.value);
        if (chosenDate.getDay() === 0 || chosenDate.getDay() === 6) {
            dateInput.setCustomValidity("Please choose a date that is not a Saturday or Sunday");
        } else {
            dateInput.setCustomValidity("");
        }
    });
</script>
<!-- <script>
    function validateTime() {
        var timeInput = document.getElementById('timeInput');
        var selectedTime = timeInput.value;

        if (selectedTime === '09:00' || selectedTime === '15:00') {
            var startTimeInput = document.getElementById('timeInput');
            var endTimeInput = document.getElementById('endTimeInput');

            // Get the selected start time value
            var startTime = startTimeInput.value;

            // If start time is not selected, reset the end time input value and disable it
            if (startTime === '') {
                endTimeInput.value = '';
                endTimeInput.disabled = true;
                return;
            }

            // Convert the start time value to a date object
            var startDate = new Date();
            var timeParts = startTime.split(':');
            startDate.setHours(timeParts[0]);
            startDate.setMinutes(timeParts[1]);

            // Add 2 hours to the start time to get the end time
            startDate.setHours(startDate.getHours() + 2);

            // Convert the end time value to a string in "hh:mm" format
            var endTime = ('0' + startDate.getHours()).slice(-2) + ':' + ('0' + startDate.getMinutes()).slice(-2);

            // Set the calculated end time value and enable the end time input
            endTimeInput.value = endTime;
            endTimeInput.disabled = false;
        } else {
            // Reset the input value to empty
            timeInput.value = '';
            // Display an error message or perform any other action
            alert('Please select either 9.00am or 3.00pm.');
        }
    }
</script> -->
@endsection