@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-center">{{ __('Contractor Detail') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('storecontractorinfo') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="company" class="col-md-4 col-form-label text-md-end">{{ __('Company Name') }}</label>

                            <div class="col-md-6">
                                <input id="company" type="text" class="form-control" name="companyName" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phoneNo" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                            <div class="col-md-6">
                                <input id="phoneNo" type="text" class="form-control" name="phoneNo" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phoneNo" class="col-md-4 col-form-label text-md-end">{{ __('Validity Pass Expiry Date') }}</label>

                            <div class="col-md-6">
                                <input id="validityDate" type="date" class="form-control" name="validityPass" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="purpose" class="col-md-4 col-form-label text-md-end">{{ __('Purpose') }}</label>

                            <div class="col-md-6">
                                <input id="purpose" type="text" class="form-control" name="purpose" required autofocus>
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