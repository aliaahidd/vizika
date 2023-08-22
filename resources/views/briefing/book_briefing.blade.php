@extends('layouts.app')
<a class="text-danger" href="{{ route('logout') }}" style="display: block; padding: 10px" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
    <i class="material-icons text-danger">&#xE879;</i> Logout </a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

@section('content')
<div class="container">
    <ul class="steps">
        <li class="step step--complete step--inactive">
            <span class="step__icon"></span>
            <span class="step__label">Step 1: User details</span>
        </li>
        <li class="step step--incomplete step--active">
            <span class="step__icon"></span>
            <span class="step__label">Step 2: Safety Briefing</span>
        </li>
        <li class="step step--incomplete step--inactive">
            <span class="step__icon"></span>
            <span class="step__label">Step 3: Capture Picture</span>
        </li>
        <li class="step step--incomplete step--inactive">
            <span class="step__icon"></span>
            <span class="step__label">Step 3: Finish</span>
        </li>
    </ul>
    <br>
    <div class="card mt-20 mb-3">
        <div class="card-body">
            <label>Have an active validity pass:</label>
            <input type="radio" name="firstTimer" value="Yes" onclick="toggleCards('activePass')">Yes
            <input type="radio" name="firstTimer" value="No" onclick="toggleCards('NotActivePass')">No
        </div>
    </div>
    <div class="card mt-20" id="activePass" style="display: none;">
        <div class="card-body">
            <!-- form add proposal -->
            <form method="POST" action="{{ route('updateProfileContractor', Auth::user()->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="validityPass" class="col-form-label text-md-end">{{ __('Validity Pass Expiry Date') }}<span style="color: red; margin-left: 5px">*</span></label>
                            <input id="validityDate" type="date" class="form-control" name="validityPass" required autofocus>
                        </div>
                        <div class="row mb-3">
                            <label for="image" class="col-form-label text-md-end">{{ __('Validity Pass Photo') }}<span style="color: red; margin-left: 5px">*</span></label>
                            <input type="file" name="validityPassImg" class="form-control" id="image" accept="image/*" onchange="loadImage2(this)" required>
                        </div>
                    </div>
                    <div class="col-md-6">
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

                <input type="submit" name="SubmitProposal" class="btn btn-primary" id="proposalform" style="float: right;" value="Next">
            </form>
        </div>
    </div>


    <div class="card mt-20" id="notActivePass" style="display: none;">
        <div class="card-body">
            <!-- form add proposal -->
            <form method="POST" action="{{ route('storecontractorinfo') }}" enctype="multipart/form-data">
                @csrf

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Time Start</th>
                            <th>Time End</th>
                            <th>Total Participant</th>
                            <th>Enroll</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($briefinginfolist As $key=>$data)
                        <tr id="row{{$data->id}}">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->briefingDate }}</td>
                            <td>{{ $data->briefingTimeStart }}</td>
                            <td>{{ $data->briefingTimeEnd }}</td>
                            <td>{{ $data->totalParticipants ?? 0 }}/{{ $data->maxParticipant }}</td>
                            <td>
                                @if ($data->enrollmentOpen)
                                <a class="btn btn-primary" href="{{ route('enrollbriefingfirsttimer', $data->id) }}">Enroll</a>
                                @else
                                <label>Already full</label>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
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

    <style>
        @import "color-schemer";

        /* Mixins */
        /* Color Variables */
        /* Theme Variables */
        /* Animations */
        @keyframes bounce {
            0% {
                transform: scale(1);
            }

            33% {
                transform: scale(0.9);
            }

            66% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }


        /* Component Styles - Steps */
        .steps {
            display: flex;
            width: 100%;
            margin: 0;
            padding: 0 0 2rem 0;
            list-style: none;
            justify-content: space-between;
        }

        .step {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            flex: 1;
            position: relative;
            pointer-events: none;
            text-align: center;
        }

        .step--active,
        .step--complete {
            cursor: pointer;
            pointer-events: all;
        }

        .step:not(:last-child):before,
        .step:not(:last-child):after {
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            height: 0.25rem;
            content: '';
            transform: translateY(-50%);
            will-change: width;
            z-index: -1;
        }

        .step:before {
            width: 100%;
            background-color: #b6b8ba;
        }

        .step:after {
            width: 0;
            background-color: #007bff;
        }

        .step--complete:after {
            width: 100% !important;
            opacity: 1;
            transition: width 0.6s ease-in-out, opacity 0.6s ease-in-out;
        }

        .step__icon {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            width: 3rem;
            height: 3rem;
            background-color: #292627;
            border: 0.25rem solid #b6b8ba;
            border-radius: 50%;
            color: transparent;
            font-size: 2rem;
        }

        .step__icon:before {
            display: block;
            color: #fff;
            content: '\2713';
        }

        .step--complete.step--active .step__icon {
            color: #fff;
            transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        .step--incomplete.step--active .step__icon {
            border-color: #007bff;
            transition-delay: 0.5s;
        }

        .step--complete .step__icon {
            animation: bounce 0.5s ease-in-out;
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .step__label {
            position: absolute;
            bottom: -2rem;
            left: 50%;
            margin-top: 1rem;
            font-size: 0.8rem;
            text-transform: uppercase;
            transform: translateX(-50%);
        }

        @media (max-width: 768px) {
            .step__label {
                bottom: -4rem;
            }

            .card {
                margin-top: 20px;
            }
        }

        .step--incomplete.step--inactive .step__label {
            color: #b6b8ba;
        }

        .step--incomplete.step--active .step__label {
            color: #000;
        }

        .step--active .step__label {
            transition: color 0.3s ease-in-out;
            transition-delay: 0.5s;
        }
    </style>
    <script>
    function toggleCards(cardToShow) {
        if (cardToShow === 'activePass') {
            document.getElementById('activePass').style.display = 'block';
            document.getElementById('notActivePass').style.display = 'none';
        } else {
            document.getElementById('activePass').style.display = 'none';
            document.getElementById('notActivePass').style.display = 'block';
        }
    }
</script>