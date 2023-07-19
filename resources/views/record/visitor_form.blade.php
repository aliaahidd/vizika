<body>
    <div id="app">
        <main class="py-4">
            <div class="container-fluid " align="center" style="padding:50px">
                <div class="row justify-content-center">
                    <div class="col-sm-6 ">
                        <img src=" {{ asset('frontend') }}/images/logo.png" width="120">
                    </div>
                </div>
            </div>
            <div class="container">
                <br>
                <div class="container">
                    <div class="card">
                        <div class="card-header d-flex justify-content-center">{{ __('Visitor Detail') }}</div>
                        <div class="card-body">
                            <!-- form add proposal -->
                            <form method="POST" action="{{ route('storevisitorform') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="col-form-label text-md-end">{{ __('Name') }}<span style="color: red; margin-left: 5px">*</span></label>
                                            <input id="name" type="text" class="form-control" name="name" placeholder="Ex: Ali bin Abu" required autofocus>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="col-form-label text-md-end">{{ __('Email') }}<span style="color: red; margin-left: 5px">*</span></label>
                                            <input id="email" type="email" class="form-control" name="email" placeholder="Ex: ali@gmail.com" required autofocus>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phoneNo" class="col-form-label text-md-end">{{ __('Phone Number') }}<span style="color: red; margin-left: 5px">*</span></label>
                                            <input id="phoneNo" type="text" class="form-control" name="phoneNo" placeholder="Ex: 0123456789" required autofocus>
                                        </div>
                                        <div class="mb-3">
                                            <label for="companyName" class="col-form-label text-md-end">{{ __('Company Name') }}<span style="color: red; margin-left: 5px">*</span></label>
                                            <select id="companyName" class="form-control" name="companyName" required>
                                                <option value="">Please select</option>
                                                @foreach ($companylist as $data)
                                                <option value="{{ $data->id }}">{{ $data->companyName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="employeeNo" class="col-form-label text-md-end">{{ __('Employee ID') }}<span style="color: red; margin-left: 5px">*</span></label>
                                            <input id="employeeNo" type="text" class="form-control" name="employeeNo" placeholder="Ex: ABC123" required autofocus>
                                        </div>
                                        <div class="mb-3">
                                            <label for="occupation" class="col-form-label text-md-end">{{ __('Occupation') }}<span style="color: red; margin-left: 5px">*</span></label>
                                            <input id="occupation" type="text" class="form-control" name="occupation" placeholder="Ex: Manager" rows="1" cols="50" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="purpose" class="col-form-label text-md-end">{{ __('Visit Purpose') }}<span style="color: red; margin-left: 5px">*</span></label>
                                            <textarea id="purpose" type="text" class="form-control" name="visitPurpose" rows="1" cols="50" placeholder="Audit" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <input type="submit" name="SubmitProposal" class="btn btn-primary" id="proposalform" style="float: right;" value="Submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="col-md-12 row justify-content-center">
            <div class="copyright">
                <span class="copyright ml-auto my-auto mr-2">Copyright © {{ now()->year }}
                    <a href="#" rel="nofollow">Vizika</a>
                </span>
            </div>
        </div>
    </div>
</body>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="SEP GROUP">
    <meta name="keywords" content="SEP GROUP">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="icon" href="{{ URL::asset('logo-vizika.png') }}" type="image/x-icon" />

    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="{{ asset('frontend') }}/css/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/css/extras.1.1.0.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/DataTables/datatables.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/css/bootstrap-select.min.css" rel="stylesheet">

    <!-- drag and drop file for proposal -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- sweet alert fire -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .info-color {
            color: #B5CCCE;
        }
    </style>


    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0;
        }

        form label {
            font-weight: bold;
        }

        /* overwrite select design */
        .bootstrap-select>.dropdown-toggle.bs-placeholder,
        .bootstrap-select>.dropdown-toggle.bs-placeholder:active,
        .bootstrap-select>.dropdown-toggle.bs-placeholder:focus,
        .bootstrap-select>.dropdown-toggle.bs-placeholder:hover,
        .bootstrap-select {
            color: black;
            font-weight: 500;
            color: #2d2d2d;
            background-color: white;
            border: 1px solid #e1e5eb;
            line-height: 1.5;
        }

        .filter-option-inner-inner,
        .dropdown-toggle {
            line-height: 1.5;
            font-weight: 500;
        }

        /* START STYLE FOR DRAG AND DROP PROPOSAL */
        .drag-area {
            border: 2px dashed #2d2d2d;
            height: 300px;
            width: 500px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .drag-area.active {
            border: 2px solid #2d2d2d;
        }

        .drag-area .icon {
            font-size: 70px;
            color: #2d2d2d;
        }

        .drag-area header {
            font-size: 30px;
            font-weight: 500;
            color: #2d2d2d;
        }

        .drag-area span {
            font-size: 25px;
            font-weight: 500;
            color: #2d2d2d;
            margin: 10px 0 15px 0;
        }

        .drag-area button {
            padding: 10px 25px;
            font-size: 20px;
            font-weight: 500;
            border: none;
            outline: none;
            background: #2d2d2d;
            color: #5256ad;
            border-radius: 5px;
            cursor: pointer;
        }

        .drag-area img {
            height: 70%;
            width: 70%;
            object-fit: cover;
            border-radius: 5px;
        }

        /* END STYLE FOR DRAG AND DROP PROPOSAL */
    </style>



    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/js/bootstrap-select.min.js"></script>
</head>