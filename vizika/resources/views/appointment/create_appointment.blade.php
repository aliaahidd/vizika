@extends('layouts.sideNav')

@section('content')
<h4>Appointment</h4>
<h6>Appointment / Create New Appointment</h6>

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<style>
    #selectedList button {
        float: right;
    }
</style>

<!-- message box if the new appointment has been added -->
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<div class="row">
    <div class="col-12" id="cardCol">
        <div class="card">
            <div class="card-body">
                <!-- form create new appointment -->
                <form method="POST" enctype="multipart/form-data" id="appointment">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label>Date</label>
                            <input type="date" name="appointmentDate" class="form-control" id="txtDate" required>
                        </div>
                        <div class="col">
                            <label>Time</label>
                            <input type="time" name="appointmentTime" class="form-control" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label>Purpose</label>
                            <select class="form-control" name="appointmentPurpose">
                                <option value="">Please select</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Meeting">Meeting</option>
                                <option value="Visit">Visit</option>
                                <option value="Audit">Audit</option>
                                <option value="Enforcement Agency">Enforcement Agency</option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Agenda</label>
                            <input type="text" name="appointmentAgenda" class="form-control" placeholder="Appointment Agenda" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="userType">User Type:</label>
                            <!-- Select the visitor type  -->
                            <select class="form-control" id="userType" onchange="toggleDropdown()">
                                <option value="">Please select</option>
                                <option value="Contractor">Contractor</option>
                                <option value="Visitor">Visitor</option>
                            </select>
                            <br>

                            <div class="overflow-auto" style="overflow:hidden;display:none;" id="contractorlistlabel">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="contractorTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th style="width: 95%">Checkbox</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($contractorlist As $key=>$data)
                                            <tr id="row{{$data->id}}">
                                                <td><input type="checkbox" name="checkboxContractor"></td>
                                                <td style="width: 95%">{{ $data->name }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="overflow-auto" style="overflow:hidden;display:none;" id="visitorlistlabel">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="visitorTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th style="width: 95%">Checkbox</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($visitorlist As $key=>$data)
                                            <tr id="row{{$data->id}}">
                                                <td><input type="checkbox" name="checkboxContractor"></td>
                                                <td style="width: 95%">{{ $data->name }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary" id="selectBtn" onclick="addToSelectedList()">Select</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="col-4" id="listNameCard" style="display:none;">
        <div class="card">
            <div class="card-body">
                <h5>List Name</h5>
                <table id="selectedList" style="width: 100%" class="mb-3"></table>
                <button type="button" class="btn btn-primary" onclick="inviteSelectedUsers()" style="float: right">Invite</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js'></script>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    // to search the appointment 
    $(document).ready(function() {
        function initializeDataTable(tableId) {
            $(tableId).DataTable({
                "order": [
                    [0, "asc"]
                ],
                "language": {
                    search: '<i class="fa fa-search" aria-hidden="true"></i>',
                    searchPlaceholder: 'Search name'
                }
            });
        }

        initializeDataTable('#contractorTable');
        initializeDataTable('#visitorTable');


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

<!-- to avoid user choose the past date -->
<script>
    // get the current date
    var today = new Date();

    // add 3 days to the current date
    var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 4);

    // convert the date to ISO format
    var minDateISO = minDate.toISOString().slice(0, 10);

    // set the minimum value of the date input field
    document.getElementById("txtDate").setAttribute("min", minDateISO);

    const dateInput = document.getElementById("txtDate");

    dateInput.addEventListener("input", () => {
        const chosenDate = new Date(dateInput.value);
        if (chosenDate.getDay() === 0 || chosenDate.getDay() === 6) {
            dateInput.setCustomValidity("Please choose a date that is not a Saturday or Sunday");
        } else {
            dateInput.setCustomValidity("");
        }
    });
</script>
<script>
    let selectedItems = []; // Array to store selected items

    function toggleDropdown() {
        const userType = document.getElementById("userType");
        const contractorlistlabel = document.getElementById("contractorlistlabel");
        const visitorlistlabel = document.getElementById("visitorlistlabel");

        if (userType.value === "Contractor") {
            visitorlistlabel.style.display = "none";
            contractorlistlabel.style.display = "block";
        } else if (userType.value === "Visitor") {
            contractorlistlabel.style.display = "none";
            visitorlistlabel.style.display = "block";
        } else {
            contractorlistlabel.style.display = "none";
            visitorlistlabel.style.display = "none";
        }
    }

    function addToSelectedList() {
        // change col from 12 to 8 
        $('#cardCol').removeClass('col-12').addClass('col-8');
        // to display the hidden card
        const selectedCard = document.getElementById('listNameCard');
        selectedCard.style.display = 'block';


        const userType = document.getElementById("userType").value;

        if (userType === "Contractor") {
            const contractorList = document.querySelectorAll("#contractorlistlabel table tbody tr");
            const selectedContractors = Array.from(contractorList)
                .filter(row => row.querySelector("input[type='checkbox']").checked)
                .map(row => {
                    const name = row.querySelector("td:last-child").textContent;
                    return name;
                });

            selectedContractors.forEach(name => {
                if (!selectedItems.includes(name)) {
                    selectedItems.push(name);
                }
            });
        } else if (userType === "Visitor") {
            const visitorList = document.querySelectorAll("#visitorlistlabel table tbody tr");
            const selectedVisitors = Array.from(visitorList)
                .filter(row => row.querySelector("input[type='checkbox']").checked)
                .map(row => {
                    const name = row.querySelector("td:last-child").textContent;
                    return name;
                });

            selectedVisitors.forEach(name => {
                if (!selectedItems.includes(name)) {
                    selectedItems.push(name);
                }
            });
        }

        updateSelectedList(selectedItems);
    }


    function updateSelectedList(selectedNames) {
        const selectedList = document.getElementById("selectedList");
        selectedList.innerHTML = ""; // Clear the list

        selectedNames.forEach((name, index) => {
            const row = document.createElement("tr");

            // Create table cells for the number, name, and delete button
            const numberCell = document.createElement("td");
            numberCell.textContent = index + 1;

            const nameCell = document.createElement("td");
            nameCell.textContent = name;

            const deleteCell = document.createElement("td");
            const deleteButton = document.createElement("button");
            deleteButton.textContent = "Delete";
            deleteButton.classList.add("btn", "btn-danger");
            deleteButton.addEventListener("click", () => {
                removeSelectedName(name);
            });
            deleteCell.appendChild(deleteButton);

            // Add cells to the row
            row.appendChild(numberCell);
            row.appendChild(nameCell);
            row.appendChild(deleteCell);

            // Add the row to the table
            selectedList.appendChild(row);
        });

        // Check if the array is empty
        const selectedCard = document.getElementById('listNameCard');
        if (selectedNames.length === 0) {
            selectedCard.style.display = "none";
            $('#cardCol').removeClass('col-8').addClass('col-12');
        } else {
            selectedCard.style.display = "block";
        }
    }

    function removeSelectedName(name) {
        const index = selectedItems.indexOf(name);
        if (index > -1) {
            selectedItems.splice(index, 1);
            updateSelectedList(selectedItems);
            unselectItemByName(name);
        }
    }

    function unselectItemByName(name) {
        const userType = document.getElementById("userType").value;

        if (userType === "Contractor") {
            const contractorList = document.querySelectorAll("#contractorlistlabel table tbody tr");
            Array.from(contractorList).forEach(row => {
                const itemName = row.querySelector("td:last-child").textContent;
                if (itemName === name) {
                    const checkbox = row.querySelector("input[type='checkbox']");
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                }
            });
        } else if (userType === "Visitor") {
            const visitorList = document.querySelectorAll("#visitorlistlabel table tbody tr");
            Array.from(visitorList).forEach(row => {
                const itemName = row.querySelector("td:last-child").textContent;
                if (itemName === name) {
                    const checkbox = row.querySelector("input[type='checkbox']");
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                }
            });
        }
    }
</script>
<script>
    function inviteSelectedUsers() {
        const selectedItems = document.querySelectorAll("input[type='checkbox']:checked");
        if (selectedItems.length === 0) {
            alert("No users selected.");
            return;
        }

        const appointmentDate = document.getElementsByName("appointmentDate")[0].value;
        const appointmentTime = document.getElementsByName("appointmentTime")[0].value;
        const appointmentPurpose = document.getElementsByName("appointmentPurpose")[0].value;
        const appointmentAgenda = document.getElementsByName("appointmentAgenda")[0].value;

        const appointments = [];

        selectedItems.forEach(item => {
            const id = item.parentNode.parentNode.id.substring(3);
            const name = item.parentNode.parentNode.querySelector("td:last-child").textContent;

            // Check if the required data is available
            if (id && name && appointmentDate && appointmentTime && appointmentPurpose && appointmentAgenda) {
                const appointment = {
                    contVisitID: id,
                    name: name,
                    appointmentDate: appointmentDate,
                    appointmentTime: appointmentTime,
                    appointmentPurpose: appointmentPurpose,
                    appointmentAgenda: appointmentAgenda
                };
                appointments.push(appointment);
            }
            // console.log(JSON.stringify(appointments));
            // Check if any appointments were added
            if (appointments.length === 0) {
                alert("No valid appointments to create.");
                return;
            }
        });

        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        $.ajax({
            url: '/set-appointment-multiple',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            data: JSON.stringify({
                appointments
            }),
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    if (response.redirect) {
                        window.location.href = response.redirect; // Redirect to the specified URL
                    } else {
                        location.reload(); // Refresh the page if no redirect URL is provided
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function(error) {
                console.error('Error:', error);
                alert("An error occurred during the request.");
            }
        });

    }
</script>

@endsection