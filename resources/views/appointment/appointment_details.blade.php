@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Appointment</h1>
        <h6><a href="{{ route('appointment') }}">List Appointment </a>/ Appointment Details</h6>
    </div>
</div>

<br>
<!-- display all from registration -->
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card" style="padding: 20px; height: 100%">
            <div class=" col-12">
                <h5>Appointment Details</h5>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <label for="date">Appointment Date</label>
                    </div>
                    <div class="col">
                        <label for="date">{{ $appointmentVisitor->appointmentDate }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="time">Appointment Time</label>
                    </div>
                    <div class="col">
                        <label for="time">{{ $appointmentVisitor->appointmentTime }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="purpose">Appointment Purpose</label>
                    </div>
                    <div class="col">
                        <label for="purpose">{{ $appointmentVisitor->appointmentPurpose }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="agenda">Appointment Agenda</label>
                    </div>
                    <div class="col">
                        <label for="agenda">{{ $appointmentVisitor->appointmentAgenda }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="staff">KANEKA Staff</label>
                    </div>
                    <div class="col">
                        <label for="staff">{{ $appointmentVisitor->name }}</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="laptop">Bring Vehicle?</label>
                    </div>
                    <div class="col">
                        @if(!$vehicleExist)
                        <input type="radio" name="bringVehicle" value="Yes" required onclick="toggleVehicleInfoForm(true)"> Yes
                        <input type="radio" name="bringVehicle" value="No" required onclick="toggleVehicleInfoForm(false)" checked> No
                        @else
                        <label for="yes">Yes</label>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="laptop">Bring laptop?</label>
                    </div>
                    <div class="col">
                        @if(!$laptopExist)
                        <input type="radio" name="bringLaptop" value="Yes" required onclick="toggleLaptopInfoForm(true)"> Yes
                        <input type="radio" name="bringLaptop" value="No" required onclick="toggleLaptopInfoForm(false)" checked> No
                        @else
                        <label for="yes">Yes</label>
                        @endif
                    </div>
                </div>

                @if(!$vehicleExist)
                <div id="vehicleInfoForm" style="display: none;" class="mt-3 mb-3">
                    <h5>Vehicle Information</h5>
                    <hr>
                    <!-- Insert laptop info form here -->
                    <form method="post" action="{{ route('vehicleinfo', $appointmentVisitor->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <label for="Vehicle">Vehicle Type<span style="color: red; margin-left: 5px">*</span></label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="vehicleType" placeholder="Vehicle Type" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label for="Vehicle">Vehicle Brand<span style="color: red; margin-left: 5px">*</span></label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="vehicleBrand" placeholder="Vehicle Brand" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label for="Vehicle">Vehicle Color<span style="color: red; margin-left: 5px">*</span></label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="vehicleColor" placeholder="Vehicle Color" required>
                            </div>
                        </div>
                        <br>
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="Vehicle">Vehicle Register No<span style="color: red; margin-left: 5px">*</span></label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="vehicleRegNo" placeholder="Vehicle Register Number" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <input type="submit" name="submitVehicle" class="btn btn-primary" value="Save" style="float: right;">
                        </div>
                    </form>
                </div>

                @else
                <div id="vehicleInfoForm" class="mt-3">
                    <h5>Vehicle Information</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="laptop">Vehicle Type</label>
                        </div>
                        <div class="col">
                            <label for="laptop">{{ $vehicleinfo->vehicleType }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="laptop">Vehicle Brand</label>
                        </div>
                        <div class="col">
                            <label for="laptop">{{ $vehicleinfo->vehicleBrand }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="laptop">Vehicle Color</label>
                        </div>
                        <div class="col">
                            <label for="laptop">{{ $vehicleinfo->vehicleColor }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="laptop">Vehicle Register No</label>
                        </div>
                        <div class="col">
                            <label for="laptop">{{ $vehicleinfo->vehicleRegNo }}</label>
                        </div>
                    </div>
                </div>
                @endif

                @if(!$laptopExist)
                <div id="laptopInfoForm" style="display: none;" class="mt-3 mb-3">
                    <h5>Laptop Information</h5>
                    <hr>
                    <!-- Insert laptop info form here -->
                    <form method="post" action="{{ route('laptopinfo', $appointmentVisitor->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <label for="laptop">Laptop Brand<span style="color: red; margin-left: 5px">*</span></label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="laptopBrand" placeholder="Laptop Brand" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label for="laptop">Laptop Model<span style="color: red; margin-left: 5px">*</span></label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="laptopModel" placeholder="Laptop Model" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label for="laptop">Laptop Color<span style="color: red; margin-left: 5px">*</span></label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="laptopColor" placeholder="Laptop Color" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label for="laptop">Laptop Serial No<span style="color: red; margin-left: 5px">*</span></label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="laptopSerialNo" placeholder="Laptop Serial Number" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <input type="submit" name="submitLaptop" class="btn btn-primary" value="Save" style="float: right">
                        </div>
                    </form>
                </div>

                @else
                <div id="laptopInfoForm" class="mt-3">
                    <h5>Laptop Information</h5>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="laptop">Laptop Brand</label>
                        </div>
                        <div class="col">
                            <label for="laptop">{{ $laptopinfo->laptopBrand }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="laptop">Laptop Model</label>
                        </div>
                        <div class="col">
                            <label for="laptop">{{ $laptopinfo->laptopModel }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="laptop">Laptop Color</label>
                        </div>
                        <div class="col">
                            <label for="laptop">{{ $laptopinfo->laptopColor }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="laptop">Laptop Serial No</label>
                        </div>
                        <div class="col">
                            <label for="laptop">{{ $laptopinfo->laptopSerialNo }}</label>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row mt-3">
                    <div class="btn-group">
                        @if($appointmentVisitor->appointmentStatus =='Pending')
                        <a class="btn btn-success" style="color: white" href="{{ route('attendvisit', $appointmentVisitor->appointmentID) }}">Attend</a>&nbsp
                        <a class="btn btn-danger" style="color: white" href="{{ route('notattendvisit', $appointmentVisitor->appointmentID) }}">Not Attend</a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<br>

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
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
                searchPlaceholder: 'Search record'
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
    function toggleLaptopInfoForm(showForm) {
        var laptopInfoForm = document.getElementById("laptopInfoForm");
        laptopInfoForm.style.display = showForm ? "block" : "none";
    }

    function toggleVehicleInfoForm(showForm) {
        var vehicleInfoForm = document.getElementById("vehicleInfoForm");
        vehicleInfoForm.style.display = showForm ? "block" : "none";
    }
</script>

@endsection