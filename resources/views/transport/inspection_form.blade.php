@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Transport</h1>
        <h6><a href="{{ route('transportInspection') }}">List Transport Inspection </a> /
            <a>Inspection Form</a>
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
        <!-- inspection form -->
        <form method="POST" action="{{ route('storeinspection') }}" enctype="multipart/form-data" id="inspection">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label>Date<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="date" name="visitDate" class="form-control" id="txtDate" required>
                    <br>
                    <label>Plate No<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="text" name="vehicleRegNo" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Company<span style="color: red; margin-left: 5px">*</span></label>
                    <select id="companyID" class="form-control" name="companyID" required>
                        <option value="">Please select</option>
                        @foreach ($companylist as $data)
                        <option value="{{ $data->id }}">{{ $data->companyName }}</option>
                        @endforeach
                    </select>
                    <br>
                    <label>Security<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="text" name="security" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 mb-3">
                    <div class="overflow-auto" style="overflow:auto;">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center">
                                        <th colspan="2">Prime Mover</th>
                                        <th colspan="4">Trailer</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>Inside</th>
                                        <th>Back</th>
                                        <th>Under</th>
                                        <th>Behind</th>
                                        <th>Left</th>
                                        <th>Right</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td><input type="checkbox" name="primeMoverInside"></td>
                                        <td><input type="checkbox" name="primeMoverBack"></td>
                                        <td><input type="checkbox" name="trailerUnder"></td>
                                        <td><input type="checkbox" name="trailerBehind"></td>
                                        <td><input type="checkbox" name="trailerLeft"></td>
                                        <td><input type="checkbox" name="trailerRight"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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