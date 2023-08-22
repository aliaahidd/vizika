@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-12 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Send Registration Link</h1>
        <h6>
            <a>Send Registration Link Form</a>
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
        <form method="POST" action="{{ route('sendinvitationemail') }}" enctype="multipart/form-data" id="appointment">
            @csrf
            <div class="row">
                <div class="col">
                    <label>Name / Person In Charge<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                    <br>
                    <label>Email / Email In Charge<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <br>
                    <label>User Type<span style="color: red; margin-left: 5px">*</span></label>
                    <select class="form-control" id="userType" name="category" onchange="toggleDropdown()">
                        <option value="">Please select</option>
                        <option value="Company">Company</option>
                        <option value="Contractor">Contractor</option>
                        <option value="Visitor">Visitor</option>
                    </select>
                    <br>
                    <div id="companyInput" style="display: none;">
                        <label>Company<span style="color: red; margin-left: 5px">*</span></label>
                        <select id="companyID" class="form-control" name="companyID" required>
                            <option value="">Please select</option>
                            @foreach ($companylist as $data)
                            <option value="{{ $data->id }}">{{ $data->companyName }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <br>
            <div class="row justify-content-end">
                <a href="javascript:history.go(-1)" class="btn btn-danger pull-right mr-2">Cancel</a>
                <input type="submit" value="Send Invitation" onclick="register(this)" name="submit" class="btn btn-primary" id="registerVisitor" style="float: right;">
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
            title: 'Registration Link Sent',
            text: "Registration links has been successfully",
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
<script>
    function toggleDropdown() {
        var userTypeSelect = document.getElementById("userType");
        var companyInput = document.getElementById("companyInput");

        if (userTypeSelect.value === "Contractor" || userTypeSelect.value === "Visitor") {
            companyInput.style.display = "block";
        } else if (userTypeSelect.value === "Company") {
            companyInput.style.display = "none";
        }
    }
</script>


@endsection