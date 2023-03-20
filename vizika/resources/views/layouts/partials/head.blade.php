<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="SEP GROUP">
    <meta name="keywords" content="SEP GROUP">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title Page -->
    <title>{{ config('app.name', 'Petakom') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon" />

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