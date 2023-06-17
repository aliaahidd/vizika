@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-12 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Company</h1>
        <h6><a href="{{ route('company') }}">Company List</a> /
            <a>Create new company</a>
        </h6>
    </div>
</div>

<!-- message box if the new visitor has been added -->
@if(session()->has('message'))
<div class="alert alert-danger">
    {{ session()->get('message') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <!-- form register new visitor -->
        <form method="POST" action="{{ route('storecompanyinfo') }}" enctype="multipart/form-data" id="company">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label>Name<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                    <br>
                    <label>Email<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label>Phone Number<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="text" name="phoneNo" class="form-control" placeholder="Phone Number" required>
                    <br>
                    <label>Address<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                </div>
            </div>
            <div class="row justify-content-end">
                <a href="javascript:history.go(-1)" class="btn btn-danger pull-right mr-2">Cancel</a>
                <input type="submit" value="Register" onclick="register(this)" name="submit" class="btn btn-primary" id="registerCompany" style="float: right;">
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
            title: 'Company information created',
            text: "Company created successfully",
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