@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-4">Profile</h1>
        @if (Auth::user()->category == 'Contractor')
        <h6><a href="{{ route('profile', $contractor->contID) }}">Profile </a> /
            @elseif (Auth::user()->category == 'Visitor')
            <h6><a href="{{ route('profile', $visitor->visitID) }}">Profile </a> /
                @endif
                <a>Edit Profile</a>
            </h6>
    </div>
</div>

<!-- to display the alert message if the record has been deleted -->
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<!-- display all from registration -->
<div class="row justify-content-center">
    @if (Auth::user()->category == 'Contractor')
    <div class="col-md-12">
        <form method="POST" action="{{ route('updateProfileContractor', $contractor->contID) }}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4" style="padding: 30px;">
                        <div class="col-md-12">
                            <label for="name">Passport Photo</label>
                            <img id="imgPreview" src="/assets/{{Auth::user()->name}}/{{$contractor->facialRecognition}}" width="100%">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $contractor->name }}" readonly>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $contractor->email }}" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="phoneNo">Phone Number</label>
                                    <input type="phoneNo" class="form-control" id="phoneNo" name="phoneNo" value="{{ $contractor->phoneNo }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="companyName">Company Name</label>
                                    <select id="companyID" class="form-control" name="companyID" required>
                                        <option value="{{ $contractor->companyID }}">{{ $contractor->companyName }}</option>
                                        @foreach ($companylist as $data)
                                        <option value="{{ $data->id }}">{{ $data->companyName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="expiryDate">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $contractor->address }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="birthDate">Employee No</label>
                                    <input type="text" class="form-control" id="employeeNo" name="employeeNo" value="{{ $contractor->employeeNo }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="expiryDate">Pass Expiry Date</label>
                                    <input type="date" class="form-control" id="passExpiryDate" name="passExpiryDate" value="{{ $contractor->passExpiryDate }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="birthDate">Birth Date</label>
                                    <input type="date" class="form-control" id="birthDate" name="birthDate" value="{{ $contractor->birthDate }}" required>
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="col-md-12 mb-4">
                                    <label for="address">Validity Pass Photo</label>
                                    <input type="file" class="form-control" id="validityPass" name="validityPassImg" accept="image/*" onchange="loadImage2(this)">
                                    <br>
                                    <img src="/assets/pass/{{$contractor->validityPassPhoto}}" id="imgPreview2" width="300px">
                                </div>
                            </div>
                            <div class="row d-flex justify-content-end">
                                <div class="col-md-12 mb-4">
                                    <a href="javascript:history.go(-1)" class="btn btn-danger mr-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @elseif (Auth::user()->category == 'Visitor')
    <div class="col-md-12">
        <form method="POST" action="{{ route('updateProfileVisitor', $visitor->visitID) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4" style="padding: 30px;">
                        <div class="col-md-12">
                            <label for="name">Passport Photo</label>
                            <img id="imgPreview" src="/assets/{{Auth::user()->name}}/{{$visitor->facialRecognition}}" width="100%">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $visitor->name }}" readonly>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $visitor->email }}" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="phoneNo">Phone Number</label>
                                    <input type="phoneNo" class="form-control" id="phoneNo" name="phoneNo" value="{{ $visitor->phoneNo }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="companyName">Company Name</label>
                                    <select id="companyID" class="form-control" name="companyID" required>
                                        <option value="{{ $visitor->companyID }}">{{ $visitor->companyName }}</option>
                                        @foreach ($companylist as $data)
                                        <option value="{{ $data->id }}">{{ $data->companyName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="expiryDate">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $visitor->address }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="birthDate">Employee No</label>
                                    <input type="text" class="form-control" id="employeeNo" name="employeeNo" value="{{ $visitor->employeeNo }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="expiryDate">Occupation</label>
                                    <input type="text" class="form-control" id="occupation" name="occupation" value="{{ $visitor->occupation }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="birthDate">Birth Date</label>
                                    <input type="date" class="form-control" id="birthDate" name="birthDate" value="{{ $visitor->birthDate }}" required>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-end">
                                <div class="col-md-12 mb-4">
                                    <a href="javascript:history.go(-1)" class="btn btn-danger mr-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endif
</div>

<script>
    function loadImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imgPreview')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    function loadImage2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imgPreview2')
                    .attr('src', e.target.result)
                    .height(250);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection