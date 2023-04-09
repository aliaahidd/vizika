@extends('layouts.sideNav')

@section('content')
<h4>Appointment</h4>
<h6>Appointment / Register Visitor</h6>

<!-- message box if the new visitor has been added -->
@if(session()->has('message'))
<div class="alert alert-danger">
    {{ session()->get('message') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <!-- form register new visitor -->
        <form method="POST" action="{{ route('registervisitor') }}" enctype="multipart/form-data" id="appointment">
            @csrf
            <div class="row">
                <div class="col">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                    <br>
                    <label>Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <br>
                    <label>User Type</label>
                    <select class="form-control" id="userType" name="category" onchange="toggleDropdown()">
                        <option value="">Please select</option>
                        <option value="Contractor">Contractor</option>
                        <option value="Visitor">Visitor</option>
                    </select>
                </div>
            </div>
            <br>
            <input type="submit" value="Register" onclick="register(this)" name="submit" class="btn btn-primary" id="registerVisitor" style="float: right;">
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