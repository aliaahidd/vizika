@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-center">{{ __('Register Company') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registercompany') }}">
                        @csrf

                        <div class="row">
                            <div class="col">
                                <div class="row mb-3">
                                    <label for="companyRegNo" class="col-md-4 col-form-label text-md-end">{{ __('Registration No') }}</label>

                                    <div class="col-md-6">
                                        <input id="companyRegNo" type="text" class="form-control @error('companyRegNo') is-invalid @enderror" name="companyRegNo" value="{{ old('companyRegNo') }}" required autocomplete="companyRegNo" autofocus>

                                        @error('companyRegNo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Management PIC Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="mngtPICName" type="text" name="mngtPICName" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Management PIC Email') }}</label>

                                    <div class="col-md-6">
                                        <input id="mngtPICEmail" type="text" class="form-control" name="mngtPICEmail">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Safety PIC Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="safetyPICName" type="text" name="safetyPICName" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Safety PIC Email') }}</label>

                                    <div class="col-md-6">
                                        <input id="safetyPICEmail" type="text" class="form-control" name="safetyPICEmail">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('KANEKA Staff Name') }}</label>

                                    <div class="col-md-6">
                                        <select id="staffID" class="form-control" name="staffID" required>
                                            <option value="">Please select</option>
                                            @foreach ($stafflist as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }} ({{ $data->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4 text-center">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>

                                <br>
                                <div class="row mt-4">
                                    <div class="col-md-8 offset-md-4">
                                        <label for="register" style="font-weight:normal;">Have an account?</label>
                                        <a style="font-weight:normal;" href="{{ route('login') }}">
                                            {{ __('Login') }}
                                        </a>
                                    </div>
                                </div>

                                <!-- <div class="row mb-3">
                            <label for="category" class="col-md-4 col-form-label text-md-end">{{ __('User Type') }}</label>
                            <div class="col-md-6">
                                <input id="category" type="text" class="form-control" name="category" readonly value="Company" placeholder="Company">
                            </div>
                        </div> -->

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        // Retrieve the name value from the query parameter
        const urlParams = new URLSearchParams(window.location.search);
        const name = urlParams.get('name');
        const email = urlParams.get('email');
        const category = urlParams.get('category');

        // Populate the readonly input field with the name value
        const nameInput = document.getElementById('name');
        if (nameInput) {
            nameInput.value = name;
        }
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.value = email;
        }
        const categoryInput = document.getElementById('category');
        if (categoryInput) {
            categoryInput.value = category;
        }
    });
</script>
@endsection