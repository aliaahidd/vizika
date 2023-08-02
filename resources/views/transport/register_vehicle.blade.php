@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Transport</h1>
        <h6><a href="{{ route('transportvehicle') }}">List Vehicle </a> /
            <a>Register Vehicle</a>
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
        <!-- vehicle form -->
        <form method="POST" action="{{ route('storevehicleregistration') }}" enctype="multipart/form-data" id="vehicle">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label>Plate No<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="text" name="vehicleRegNo" class="form-control" placeholder="Plate No" required>
                    <br>
                    <label>Vehicle CC<span style="color: red; margin-left: 5px">*</span></label>
                    <select class="form-control" name="vehicleCC" required>
                        <option value="1.6CC">1.6CC</option>
                        <option value="2CC">2CC</option>
                        <option value="2.2CC">2.2CC</option>
                        <option value="3CC">3CC</option>
                    </select>
                    <br>
                    <label>Vehicle Weight<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="text" name="vehicleWeight" class="form-control" placeholder="Vehicle Weight" required>
                    <br>
                </div>

                <div class="col-md-6">
                    <label>Vehicle Type<span style="color: red; margin-left: 5px">*</span></label>
                    <select class="form-control" name="vehicleType" required>
                        <option value="Tanker">Tanker</option>
                        <option value="6 Tan Lorry">6 Tan Lorry</option>
                        <option value="10 Tan Lorry">10 Tan Lorry</option>
                        <option value="Van">Van</option>
                        <option value="Car">Car</option>
                    </select>
                    <br>
                    <label>Vehicle Colour<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="text" name="vehicleColour" class="form-control" placeholder="Vehicle Colour" required>
                    <br>
                    <label>Company<span style="color: red; margin-left: 5px">*</span></label>
                    <select id="companyID" class="form-control" name="companyID" required>
                        <option value="">Please select</option>
                        @foreach ($companylist as $data)
                        <option value="{{ $data->id }}">{{ $data->companyName }}</option>
                        @endforeach
                    </select>
                    <br>
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

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script>
    // Function to set the input value to today's date
    function setTodayDate() {
        const inputElement = document.getElementById("txtDate");
        const currentDate = new Date().toISOString().slice(0, 10);
        inputElement.value = currentDate;
    }

    // Call the function to set the value when the page loads
    window.addEventListener("load", setTodayDate);

    // Make the input field read-only
    document.getElementById("txtDate").readOnly = true;
</script>

@endsection