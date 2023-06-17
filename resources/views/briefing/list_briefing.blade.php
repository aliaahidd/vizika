@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Safety Briefing</h1>
        <h6>List Briefing</h6>
    </div>
</div>

<body>
    <!-- to display the alert message if the record has been added -->
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <div class="row justify-content-end mb-3">

        @if( auth()->user()->category== "SHEQ Officer")

        @if(request()->routeIs('briefing'))
        <div class="col-lg-12 col-md-6 col-sm-3 justify-content-end d-flex">
            <a class="btn btn-primary" style="width:170px;"role="button" href="{{ route('briefing/createbriefinginfo') }}">
                <i class="fas fa-plus"></i>&nbsp; Create Briefing</a>
        </div>
        @endif

        @endif
    </div>

    <div class="card">
        <div class="card-header pb-0">

        </div>

        <div class="card-body">
            <div class="overflow-auto" style="overflow:hidden;">
                <div class="table-responsive">
                    @if( auth()->user()->category== "SHEQ Officer")
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Time Start</th>
                                <th>Time End</th>
                                <th>Max Participant</th>
                                <th>Enrolled Participant</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($briefinginfolist As $key=>$data)
                            <tr id="row{{$data->id}}">
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->briefingDate }}</td>
                                <td>{{ $data->briefingTimeStart }}</td>
                                <td>{{ $data->briefingTimeEnd }}</td>
                                <td>{{ $data->maxParticipant }}</td>
                                <td>{{ $data->totalParticipants }}</td>
                                <td>
                                    @if ($data->enrollmentOpen)
                                    <div style="background-color: #d9f3ea; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto;">
                                        <label style="color: #0bb37a; text-align: center; font-weight: bold" class="mb-1 mt-1">Not full</label>
                                    </div>
                                    @else
                                    <div style="background-color: #ffe6e6; border-radius: 10px; display: flex; justify-content: center; align-items: center; margin: auto;">
                                        <label style="color: #ff5b5b; text-align: center; font-weight: bold" class="mb-1 mt-1">Full</label>
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($data->totalParticipants === 0)
                                    <a onclick="deleteItem(this)" data-id="{{ $data->id }}" data-name="{{ $data->briefingDate }}" class="btn btn-danger" style="justify-content: center; align-items: center; margin: auto; color: white">Delete</a>
                                    @else
                                    <a href="{{ route('briefingsession', $data->id )}}" class="btn btn-primary" style="justify-content: center; align-items: center; margin: auto; color: white">View</a>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    @if( auth()->user()->category== "Contractor")
                    @if ($alreadyenroll)
                    <div class="container">
                        <div class="row justify-content-md-center">
                            <div class="col d-flex justify-content-center">
                                <h2>You have already enrolled in the safety briefing</h2>
                            </div>
                        </div>
                        <br>
                        @foreach($briefingenrollmentdetails As $key=>$data)

                        <table style="margin-left: auto; margin-right: auto;" id="dataTable" width="30%" cellspacing="0">
                            <tr>
                                <td>
                                    <h5><i class="material-icons">event</i><span> Date</span></h5>
                                </td>
                                <td>
                                    <h5>{{ $data->briefingDate }}</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5><i class="material-icons">schedule</i><span> Time Start</span></h5>
                                </td>
                                <td>
                                    <h5>{{ $data->briefingTimeStart }}</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5><i class="material-icons">schedule</i><span> Time End</span></h5>
                                </td>
                                <td>
                                    <h5>{{ $data->briefingTimeEnd }}</h5>
                                </td>
                            </tr>
                        </table>
                    </div>
                    @endforeach

                    @else
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
                                    <a class="btn btn-primary" href="{{ route('enrollbriefing', $data->id) }}">Enroll</a>
                                    @else
                                    <label>Already full</label>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script>
    // to search the appointment 
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [0, "asc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search briefing'
            }
        });

        // filter appointment
        $('.dataTables_filter input[type="search"]').css({
            'width': '300px',
            'display': 'inline-block',
            'font-size': '15px',
            'font-weight': '400'
        });

        $('.year-dropdown').on('change', function(e) {
            var year = $(this).val();
            dataTable.column(3).search('^' + year + '-', true, false).draw();
        });
    });
</script>
<script>
    function deleteItem(e) {
        let id = e.getAttribute('data-id');
        let name = e.getAttribute('data-name');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ml-1',
                cancelButton: 'btn btn-danger mr-1'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Are you sure to delete this briefing session?',
            html: "Date: " + name + "<br> You won't be able to revert this!",
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                if (result.isConfirmed) {

                    $.ajax({
                        type: 'DELETE',
                        url: '{{url("/deletebriefingsession")}}/' + id,
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.success) {
                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'Briefing session has been deleted.',
                                    "success"
                                );

                                $("#row" + id).remove(); // you can add name div to remove
                            }


                        }
                    });

                }

            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                // swalWithBootstrapButtons.fire(
                //     'Cancelled',
                //     'Your imaginary file is safe :)',
                //     'error'
                // );
            }
        });

    }
</script>
@endsection