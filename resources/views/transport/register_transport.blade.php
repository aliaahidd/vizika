@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Contractor</h1>
        <h6><a href="{{ route('contractortransport') }}">List Transport </a> /
            <a>Register Transport</a>
        </h6>
    </div>
</div>

<!-- message box if the new briefing has been added -->
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <!-- form create new briefing -->
        <form method="POST" action="{{ route('storetransportregistration') }}" enctype="multipart/form-data" id="contractortransport">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label>Date<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="date" name="visitDate" class="form-control" id="txtDate" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Plate No<span style="color: red; margin-left: 5px">*</span></label>
                    <input type="text" name="vehicleRegNo" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Company<span style="color: red; margin-left: 5px">*</span></label>
                    <select id="companyID" class="form-control" name="companyID" required>
                        <option value="">Please select</option>
                        @foreach ($companylist as $data)
                        <option value="{{ $data->id }}">{{ $data->companyName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 mb-3">
                    <div class="overflow-auto" style="overflow:auto;">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <select id="contractorID" class="form-control" name="contractorID[]" required>
                                                <option value="">Please select</option>
                                                @foreach ($contractorlist as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger remove-row-btn">Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-secondary" id="addRowBtn">Add Row</button>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="selectedContractorIDs" id="selectedContractorIDs">

            <div class="row justify-content-end">
                <a href="javascript:history.go(-1)" class="btn btn-danger pull-right mr-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js'></script>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script>
    // Function to set the input value to today's date
    function setTodayDate() {
        const inputElement = document.getElementById("txtDate");
        const currentDate = new Date().toISOString().slice(0, 10);
        inputElement.value = currentDate;
    }

    // Call the function to set the value when the page loads
    window.addEventListener("load", setTodayDate);

    // Make the input field read-only
    document.getElementById("txtDate").readOnly = true;
</script>
<script>
    // to search the appointment 
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [1, "asc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search contractor'
            }
        });

        // filter appointment
        $('.dataTables_filter input[type="search"]').css({
            'width': '300px',
            'display': 'inline-block',
            'font-size': '15px',
            'font-weight': '400'
        });

    });
</script>
<script>
    $(document).ready(function() {
        var rowCount = 1;

        function updateRowNumbers() {
            $("#dataTable tbody tr").each(function(index) {
                $(this).find("td:first").text(index + 1);
            });
        }

        $("#addRowBtn").on("click", function() {
            rowCount++;
            var newRow = `
                <tr>
                    <td>${rowCount}</td>
                    <td>
                        <select class="form-control contractor-dropdown" name="contractorID[]" required>
                            <option value="">Please select</option>
                            @foreach ($contractorlist as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-row-btn">Remove</button>
                    </td>
                </tr>`;
            $("#dataTable tbody").append(newRow);

            // Remove selected options from other dropdowns
            $(".contractor-dropdown").each(function() {
                var selectedOption = $(this).val();
                $(".contractor-dropdown option[value='" + selectedOption + "']:not(:selected)").remove();
            });
        });

        // Remove row when the "Remove" button is clicked
        $("#dataTable").on("click", ".remove-row-btn", function() {
            $(this).closest("tr").remove();
            updateRowNumbers();

            // Reset dropdown options
            var selectedOptions = [];
            $(".contractor-dropdown").each(function() {
                var selectedOption = $(this).val();
                if (selectedOption) {
                    selectedOptions.push(selectedOption);
                }
            });

            $(".contractor-dropdown option").remove(); // Remove all options
            $(".contractor-dropdown").append('<option value="">Please select</option>');

            // Add back options to other dropdowns
            $(".contractor-dropdown").each(function() {
                var currentDropdown = $(this);
                selectedOptions.forEach(function(option) {
                    if (option !== currentDropdown.val()) {
                        currentDropdown.append('<option value="' + option + '">' + option + '</option>');
                    }
                });
            });

            // Update hidden input with selected contractor IDs
            $("#selectedContractorIDs").val(selectedOptions.join("/"));
        });
    });
</script>


@endsection