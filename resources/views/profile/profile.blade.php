@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0 d-flex">
        <h1 class="page-title">Profile</h1>
    </div>
</div>
<!-- display all from registration -->
@if (Auth::user()->category == 'Contractor')
<div class="row justify-content-end">
    <a class="mb-2 btn btn-sm  btn-outline-primary mr-2" href="{{ route('editprofile', $contractor->id ) }}">Edit Profile</a>
    <a class="mb-2 btn btn-sm  btn-outline-primary mr-2" href="{{ route('change-password', $contractor->id ) }}">
        <i class="material-icons mr-1"></i>Change Password</a>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="row justify-content-center">
            <div class="col-md-3 mb-3">
                <div class="card" style="padding: 20px; height: 450px">
                    <div class="col-12">
                        <h5>Passport Photo</h5>
                        <hr>
                        <div style="margin: auto;">
                            <img src="/assets/{{$contractor->icNo}}/{{$contractor->facialRecognition}}" width="200px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card" style="padding: 20px; height: 450px">
                    <div class=" col-12">
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
                        <br>

                        <h5>Additional Information</h5>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <label for="companyName">Company Name</label>
                            </div>
                            <div class="col">
                                <label for="companyName">{{ $contractor->companyName }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="employeeNo">Employee Number</label>
                            </div>
                            <div class="col">
                                <label for="employeeNo">{{ $contractor->employeeNo }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="expiryPass">Pass Expiry Date</label>
                            </div>
                            <div class="col">
                                <label for="expiryPass">{{ $contractor->passExpiryDate }} <a data-toggle="modal" data-target="#viewPassModal" style="color: #007bff;" id="viewPass">View Pass</a></label>
                            </div>
                        </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewPassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Validity Pass Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="justify-content-center text-center">
                    <img src="/assets/pass/{{$contractor->validityPassPhoto}}" width="400px">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@elseif (Auth::user()->category == 'Visitor')
<div class="row justify-content-end">
    <a class="mb-2 btn btn-sm  btn-outline-primary mr-2" href="{{ route('editprofile', $visitor->id ) }}">Edit Profile</a>
    <a class="mb-2 btn btn-sm  btn-outline-primary mr-2" href="{{ route('change-password', $visitor->id ) }}">
        <i class="material-icons mr-1"></i>Change Password</a>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="row justify-content-center">
            <div class="col-md-3 mb-3">
                <div class="card" style="padding: 20px; height: 430px">
                    <div style="margin: auto;">
                        <img src="/assets/{{$visitor->name}}/{{$visitor->facialRecognition}}" width="200px">
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card" style="padding: 20px; height: 430px">
                    <div class=" col-12">
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
                        <br>

                        <h5>Additional Information</h5>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <label for="companyName">Company Name</label>
                            </div>
                            <div class="col">
                                <label for="companyName">{{ $visitor->companyName }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="employeeNo">Employee ID</label>
                            </div>
                            <div class="col">
                                <label for="employeeNo">{{ $visitor->employeeNo }}</label>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif (Auth::user()->category == 'Staff' || Auth::user()->category == 'SHEQ Officer' || Auth::user()->category == 'SHEQ Guard')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-3" style="padding: 20px;">
            <div class="form-row">
                <div class="col-12">
                    <h5>Profile details</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="name">Name</label>
                        </div>
                        <div class="col">
                            <label for="name">{{ $user->name }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col">
                            <label for="email">{{ $user->email }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3" style="padding: 20px;">
            <div class="form-row">
                <div class="col-12">
                    <h5>Change Password</h5>
                    <hr>
                    <form action="{{ route('update-password') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                            @endif

                            <div class="mb-3">
                                <label for="oldPasswordInput" class="form-label">Old Password</label>
                                <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput" placeholder="Old Password">
                                @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="newPasswordInput" class="form-label">New Password</label>
                                <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput" placeholder="New Password">
                                @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                                <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput" placeholder="Confirm New Password">
                            </div>
                        </div>
                        <div class="card-footer">
                            <center><button class="btn btn-primary">Update</button></center>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection