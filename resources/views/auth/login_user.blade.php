@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-center">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name / PIC Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" readonly>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address / PIC Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" readonly>

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
                            <label for="category" class="col-md-4 col-form-label text-md-end">{{ __('User Type') }}</label>
                            <div class="col-md-6">
                                <input id="category" type="text" class="form-control" name="category" readonly>
                            </div>

                            <!-- <div class="col-md-6">
                                <select class="form-control" name="category">
                                    <option value="">Please select</option>
                                    <option value="Contractor">Contractor</option>
                                    <option value="Company">Company</option>
                                    <option value="Visitor">Visitor</option>
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> -->
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
        const email = urlParams.get('emaail');
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