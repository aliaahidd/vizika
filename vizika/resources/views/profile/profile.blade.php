@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0 d-flex">
        <h1 class="page-title ml-3">Profile</h1>
    </div>
</div>
<!-- display all from registration -->
<div class="row justify-content-center">
    <div class="col-md-8">
        @if (Auth::user()->category == 'Contractor')
        <div class="card" style="padding: 20px;">
            <div class="form-row">
                <div class="col-4">
                    <img src="/assets/{{Auth::user()->name}}/{{$contractor->passportPhoto}}" width="200px" style="float: left">
                </div>
                <div class="col-7">
                    <h5>Contact Details</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="name">Name</label>
                        </div>
                        <div class="col">
                            <label for="name">{{ $contractor->name }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $contractor->email }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Phone Number</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $contractor->phoneNo }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 mb-3">
                <div class="col-12">
                    <h5>Additional Information</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="address">Address</label>
                        </div>
                        <div class="col">
                            <label for="address">{{ $contractor->address }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="birthdate">Birth Date</label>
                        </div>
                        <div class="col">
                            <label for="birthdate">{{ $contractor->birthDate }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="passExpiryDate">Pass Expiry Date</label>
                        </div>
                        <div class="col">
                            <label for="passExpiryDatee">{{ $contractor->passExpiryDate }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="passExpiryDate">Validity Pass Photo</label>
                        </div>
                        <div class="col">
                            <img src="/assets/pass/{{$contractor->validityPassPhoto}}" height="200px" style="float: left;">
                        </div>
                    </div>
                </div>
            </div>
            <a class="btn btn-primary" href="{{ route('editprofile', $contractor->id ) }}">Edit Profile</a>
        </div>

        @elseif (Auth::user()->category == 'Visitor')
        <div class="card" style="padding: 20px;">
            <div class="form-row">
                <div class="col-4">
                    <img src="/assets/{{Auth::user()->name}}/{{$visitor->passportPhoto}}" width="200px" style="float: left">
                </div>
                <div class="col-7">
                    <h5>Contact Details</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="name">Name</label>
                        </div>
                        <div class="col">
                            <label for="name">{{ $visitor->name }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $visitor->email }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Phone Number</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $visitor->phoneNo }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5>Additional Information</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="address">Address</label>
                        </div>
                        <div class="col">
                            <label for="address">{{ $visitor->address }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="birthdate">Birth Date</label>
                        </div>
                        <div class="col">
                            <label for="birthdate">{{ $visitor->birthDate }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="employeeID">Employee ID</label>
                        </div>
                        <div class="col">
                            <label for="employeeID">{{ $visitor->employeeID }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="occupation">Occupation</label>
                        </div>
                        <div class="col">
                            <label for="occupation">{{ $visitor->occupation }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <a class="btn btn-primary" href="{{ route('editprofile', $visitor->id ) }}">Edit Profile</a>
        </div>
        @endif
    </div>
</div>
@endsection