@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Profile</h1>
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
    <div class="col-md-8">
        @if (Auth::user()->category == 'Contractor')
        <div class="card mb-3" style="padding: 20px;">
            <form method="POST" action="{{ route('updateProfileContractor', $contractor->contID) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="col-8">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $contractor->name }}" readonly>
                        <br>
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $contractor->email }}" readonly>
                        <br>
                        <label for="phoneNo">Phone Number</label>
                        <input type="phoneNo" class="form-control" id="phoneNo" name="phoneNo" value="{{ $contractor->phoneNo }}">
                    </div>
                    <div class="col-4">
                        <br>
                        <input type="file" name="passportPhoto" class="form-control">
                        <img src="/assets/{{Auth::user()->name}}/{{$contractor->passportPhoto}}" width="200px" style="float: right">
                    </div>
                </div>

                <div class="form-group">
                    <br>
                    <label for="companyName">Company Name</label>
                    <select id="companyID" class="form-control" name="companyID" required>
                        <option value="{{ $contractor->companyID }}">{{ $contractor->companyName }}</option>
                        @foreach ($companylist as $data)
                        <option value="{{ $data->id }}">{{ $data->companyName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <br>
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $contractor->address }}">
                </div>
                <div class="form-group">
                    <label for="expiryDate">Pass Expiry Date</label>
                    <input type="date" class="form-control" id="passExpiryDate" name="passExpiryDate" value="{{ $contractor->passExpiryDate }}">
                </div>
                <div class="form-group">
                    <label for="birthDate">Birth Date</label>
                    <input type="date" class="form-control" id="birthDate" name="birthDate" value="{{ $contractor->birthDate }}">
                </div>
                <div class="form-group">
                    <br>
                    <label for="address">Validity Pass Photo</label>
                    <input type="file" class="form-control" id="validityPass" name="validityPassImg">
                    <br>
                    <img src="/assets/pass/{{$contractor->validityPassPhoto}}" width="250px">
                </div>
                <div class="justify-content-end form-group">
                    <a href="javascript:history.go(-1)" class="btn btn-danger pull-right mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>f
            </form>
        </div>

        @elseif (Auth::user()->category == 'Visitor')
        <div class="card mb-3" style="padding: 20px;">
            <form method="POST" action="{{ route('updateProfileVisitor', $visitor->visitID) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="col-8">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $visitor->name }}" readonly>
                        <br>
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $visitor->email }}" readonly>
                        <br>
                        <label for="phoneNo">Phone Number</label>
                        <input type="phoneNo" class="form-control" id="phoneNo" name="phoneNo" value="{{ $visitor->phoneNo }}">
                        <br>
                        <label for="birthDate">Birth Date</label>
                        <input type="date" class="form-control" id="birthDate" name="birthDate" value="{{ $visitor->birthDate }}">
                    </div>
                    <div class="col-4">
                        <br>
                        <input type="file" name="passportPhoto" class="form-control">
                        <img src="/assets/{{Auth::user()->name}}/{{$visitor->passportPhoto}}" height="300px" style="float: right">
                    </div>
                </div>

                <div class="form-group">
                    <br>
                    <label for="companyID">Company Name</label>
                    <select id="companyID" class="form-control" name="companyID" required>
                        <option value="{{ $visitor->companyID }}">{{ $visitor->companyName }}</option>
                        @foreach ($companylist as $data)
                        <option value="{{ $data->id }}">{{ $data->companyName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <br>
                    <label for="employeeNo">Employee ID</label>
                    <input type="text" class="form-control" id="employeeNo" name="employeeNo" value="{{ $visitor->employeeNo }}">
                </div>
                <div class="form-group">
                    <br>
                    <label for="occupation">Occupation</label>
                    <input type="text" class="form-control" id="occupation" name="occupation" value="{{ $visitor->occupation }}">
                </div>
                <div class="form-group">
                    <br>
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $visitor->address }}">
                </div>
                <div class="justify-content-end form-group">
                    <a href="javascript:history.go(-1)" class="btn btn-danger pull-right mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

@endsection