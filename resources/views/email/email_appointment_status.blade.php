<h4>Appointment Status Updated</h4>
<hr>
<p>Dear {{ $data['name'] }},</p>

<p>The appointment status from {{ Auth::user()->name }} has been updated.</p>

<p>Appointment Status : <strong>{{ $data['appointmentStatus'] }}</strong>
    <br>Bring Vehicle? : <strong>{{ $data['bringVehicle'] }}</strong>
    <br>Bring Laptop? : <strong> {{ $data['bringLaptop'] }} </strong>
</p>

<p>If the visitor requested to bring laptop, please respond to allow or not in the system.</p>

<p>Thank you and have a nice day.</p>