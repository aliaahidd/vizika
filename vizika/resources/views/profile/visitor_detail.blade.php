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
                            <label for="companyName" class="col-md-4 col-form-label text-md-end">{{ __('Company Name') }}</label>

                            <div class="col-md-8">
                                <select id="companyName" class="form-control" name="companyName" required>
                                    <option value="">Please select</option>
                                    @foreach ($companylist as $data)
                                    <option value="{{ $data->companyName }}">{{ $data->companyName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="employeeID" class="col-md-4 col-form-label text-md-end">{{ __('Employee ID') }}</label>

                            <div class="col-md-8">
                                <input id="employeeID" type="text" class="form-control" name="employeeID" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="occupation" class="col-md-4 col-form-label text-md-end">{{ __('Occupation') }}</label>

                            <div class="col-md-8">
                                <input id="occupation" type="text" class="form-control" name="occupation" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phoneNo" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                            <div class="col-md-8">
                                <input id="phoneNo" type="text" class="form-control" name="phoneNo" required autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birthDate" class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>

                            <div class="col-md-8">
                                <input id="birthDate" type="date" class="form-control" name="birthDate" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

                            <div class="col-md-8">
                                <textarea id="address" type="text" class="form-control" name="address" required> </textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Profile Photo') }}</label>

                            <div class="col-md-8">
                                <input type="file" name="visitorImg" class="form-control" id="image" accept="image/*" onchange="loadImage(this)" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Preview') }}</label>

                            <div class="col-md-8">
                                <!-- to preview the file from the input type in div -->
                                <img id="imgPreview" style="width: 250px; height: 250px; border-style: dashed; margin:auto;display:flex; top:0; bottom:0; right:0; left:0;">
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4 text-center">
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

<!-- to preview the chosen file from computer -->
<script>
    function loadImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imgPreview')
                    .attr('src', e.target.result)
                    .width(250)
                    .height(250);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>