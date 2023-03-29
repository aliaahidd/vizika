@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-center">{{ __('Visitor Detail') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('storevisitorinfo') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="employeeID" class="col-md-4 col-form-label text-md-end">{{ __('Employee ID') }}</label>

                            <div class="col-md-6">
                                <input id="employeeID" type="text" class="form-control" name="employeeID" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="company" class="col-md-4 col-form-label text-md-end">{{ __('Company Name') }}</label>

                            <div class="col-md-6">
                                <input id="company" type="text" class="form-control" name="companyName" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="occupation" class="col-md-4 col-form-label text-md-end">{{ __('Occupation') }}</label>

                            <div class="col-md-6">
                                <input id="occupation" type="text" class="form-control" name="occupation" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phoneNo" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                            <div class="col-md-6">
                                <input id="phoneNo" type="text" class="form-control" name="phoneNo" required autofocus>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 text-center">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection