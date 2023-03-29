@extends('layouts.sideNav')

@section('content')
<h4>Appointment</h4>
<h6>Appointment / Create New Appointment</h6>

<!-- message box if the new appointment has been added -->
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <!-- form create new appointment -->
        <form method="POST" action="{{ route('storeappointment', $appointment->id) }}" enctype="multipart/form-data" id="appointment">
            @csrf
            <div class="row">
                <div class="col">
                    <label>Visitor Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $appointment->name }}" placeholder="Visitor Name" readonly>
                </div>
                <div class="col">
                    <label>Visitor Email</label>
                    <input type="text" name="email" class="form-control" value="{{ $appointment->email }}" placeholder="Visitor Email" readonly>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Appointment Name</label>
                    <input type="text" name="appointmentName" class="form-control" placeholder="Appointment Name" required>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label>Appointment Date</label>
                            <input type="date" name="appointmentDate" class="form-control" id="txtDate" required>
                        </div>
                        <div class="col">
                            <label>Appointment Time</label>
                            <input type="time" name="appointmentTime" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <label>Appointment Purpose</label>
                    <input type="text" name="appointmentPurpose" class="form-control" placeholder="Appointment Purpose" required>
                    <br>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6 text-left">
                    <a href="{{ route('appointment/choosevisitor') }}" class="btn btn-danger pull-right">Previous</a>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>

</div>
<script type="text/javascript" src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js'></script>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- to preview the chosen file from computer -->
<script type="text/javascript">
    $(function() {
        $("#pdffile").change(function() {
            $("#dvPreview").html("");

            $("#dvPreview").show();
            $("#dvPreview").append("<iframe />");
            $("iframe").css({
                "height": "400px",
                "width": "450px"
            });
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#dvPreview iframe").attr("src", e.target.result);
            }
            reader.readAsDataURL($(this)[0].files[0]);
        });
    });
</script>

<!-- to avoid user choose the past date -->
<script>
    $(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        $('#txtDate').attr('min', maxDate);
    });
</script>
@endsection