@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <!-- form add proposal -->
            <form method="POST" action="{{ route('storecontractorinfo') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-">
                    <div class="col">
                        <div class="mb-3">
                            <label for="companyName" class="col-form-label text-md-end">{{ __('Company Name') }}</label>
                            <select id="companyName" class="form-control" name="companyName" required>
                                <option value="">Please select</option>
                                @foreach ($companylist as $data)
                                <option value="{{ $data->companyName }}">{{ $data->companyName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNo" class="col-form-label text-md-end">{{ __('Phone Number') }}</label>
                            <input id="phoneNo" type="text" class="form-control" name="phoneNo" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="validityPass" class="col-form-label text-md-end">{{ __('Validity Pass Expiry Date') }}</label>
                            <input id="validityDate" type="date" class="form-control" name="validityPass" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="col-form-label text-md-end">{{ __('Profile Photo') }}</label>
                            <input type="file" name="contractorImg" class="form-control" id="image" accept="image/*" onchange="loadImage(this)" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="col-form-label text-md-end">{{ __('Preview') }}</label>
                        </div>
                        <div class="mb-3">
                            <!-- to preview the file from the input type in div -->
                            <div style="border-style: dashed; margin:auto;">
                                <img id="imgPreview" style="height: 250px; margin:auto; display:flex;">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="birthDate" class="col-form-label text-md-end">{{ __('Date of Birth') }}</label>
                            <input id="birthDate" type="date" class="form-control" name="birthDate" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="col-form-label text-md-end">{{ __('Address') }}</label>
                            <textarea id="address" type="text" class="form-control" name="address" rows="1" cols="50" required></textarea>
                        </div>
                        <div class="row mb-3">
                            <label for="image" class="col-form-label text-md-end">{{ __('Validity Pass Photo') }}</label>
                            <input type="file" name="validityPassImg" class="form-control" id="image" accept="image/*" onchange="loadImage2(this)" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="col-form-label text-md-end">{{ __('Preview') }}</label>
                        </div>
                        <div class="mb-3">
                            <!-- to preview the file from the input type in div -->
                            <div style="border-style: dashed; margin:auto;">
                                <img id="imgPreview2" style="height: 250px; margin:auto; display:flex;">
                            </div>
                        </div>
                    </div>
                </div>
                
                <input type="submit" name="SubmitProposal" class="btn btn-primary" id="proposalform" style="float: right;">
            </form>
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
                    .height(250);
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