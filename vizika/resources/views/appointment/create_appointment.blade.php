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
        <form method="POST" action="{{ route('storeappointment') }}" enctype="multipart/form-data" id="appointment">
            @csrf
            <div class="row">
                <div class="col">
                    <label>Date</label>
                    <input type="date" name="appointmentDate" class="form-control" id="txtDate" required>
                </div>
                <div class="col">
                    <label>Time</label>
                    <input type="time" name="appointmentTime" class="form-control" required>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <label>Purpose</label>
                    <select class="form-control" name="appointmentPurpose">
                        <option value="">Please select</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Meeting">Meeting</option>
                        <option value="Visit">Visit</option>
                        <option value="Audit">Audit</option>
                        <option value="Enforcement Agency">Enforcement Agency</option>
                    </select>
                </div>
                <div class="col">
                    <label>Agenda</label>
                    <input type="text" name="appointmentAgenda" class="form-control" placeholder="Appointment Agenda" required>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <label for="userType">User Type:</label>
                    <select class="form-control" id="userType" onchange="toggleDropdown()">
                        <option value="">Please select</option>
                        <option value="Contractor">Contractor</option>
                        <option value="Visitor">Visitor</option>
                    </select>
                    <br>

                    <label for="contractorlistlabel" id="contractorlist" style="display:none;">Contractor Name:</label>
                    <select class="form-control" id="contractorlistlabel" name="contVisit" style="display:none;">
                        @foreach($contractorlist as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endforeach
                    </select>

                    <label for="visitorlistlabel" id="visitorlist" style="display:none;">Visitor Name:</label>
                    <select class="form-control" id="visitorlistlabel" name="contVisit" style="display:none;">
                        @foreach($visitorlist as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <!-- <div class="col-md-6 text-left">
                    <a href="" class="btn btn-danger pull-right">Previous</a>
                </div> -->
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
<script>
    function toggleDropdown() {
        const userType = document.getElementById("userType");
        const contractorlistlabel = document.getElementById("contractorlistlabel");
        const contractorlist = document.getElementById("contractorlist");

        if (userType.value === "Contractor") {
            visitorlistlabel.style.display = "none";
            visitorlist.style.display = "none";
            contractorlistlabel.style.display = "block";
            contractorlist.style.display = "block";
        } else if (userType.value === "Visitor") {
            contractorlistlabel.style.display = "none";
            contractorlist.style.display = "none";
            visitorlistlabel.style.display = "block";
            visitorlist.style.display = "block";
        } else {
            contractorlistlabel.style.display = "none";
            contractorlist.style.display = "none";
            visitorlistlabel.style.display = "none";
            visitorlist.style.display = "none";
        }
    }
</script>
@endsection