@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-12 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Bulk Registration</h1>
        <h6>Create Bulk Registration</a>
        </h6>
    </div>
</div>

<!-- message box if the new visitor has been added -->
@if(session()->has('message'))
<div class="alert alert-danger">
    {{ session()->get('message') }}
</div>
@endif

<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-primary" role="button" id="contractorExcel" href="{{ route('exceldownload', ['fileType' => 'contractor']) }}">
                    Contractor Guideline
                </a>
                <a class="btn btn-primary" role="button" id="visitorExcel" href="{{ route('exceldownload', ['fileType' => 'visitor']) }}">
                    Visitor Guideline
                </a>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <!-- form register new visitor -->
        <form method="POST" action="{{ route('registerbulkfile') }}" enctype="multipart/form-data" id="appointment">
            @csrf
            <div class="row">
                <div class="col">
                    <label>User Type<span style="color: red; margin-left: 5px">*</span></label>
                    <select class="form-control" id="userType" name="category" onchange="toggleDropdown()">
                        <option value="">Please select</option>
                        <option value="Contractor">Contractor</option>
                        <option value="Visitor">Visitor</option>
                    </select>
                    <br>

                    <label>Company<span style="color: red; margin-left: 5px">*</span></label>
                    <select id="companyID" class="form-control" name="companyID" required>
                        <option value="">Please select</option>
                        @foreach ($companylist as $data)
                        <option value="{{ $data->id }}">{{ $data->companyName }}</option>
                        @endforeach
                    </select>
                    <br>

                    <label>Excel File<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="file" name="file" class="form-control" required>
                    <br>

                    <label>Zip File<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="file" name="zipfile" class="form-control" required>
                    <br>
                </div>
            </div>
            <br>
            <div class="row justify-content-end">
                <a href="javascript:history.go(-1)" class="btn btn-danger pull-right mr-2">Cancel</a>
                <input type="submit" value="Register" onclick="register(this)" name="submit" class="btn btn-primary" id="registerVisitor" style="float: right;">
            </div>
        </form>
    </div>

</div>
<script type="text/javascript" src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js'></script>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- sweet alert -->
<script>
    function register(e) {
        Swal.fire({
            title: 'Visitor account created',
            text: "Visitor registration successfully",
            icon: 'success',
            timer: 5000
        });
    }
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