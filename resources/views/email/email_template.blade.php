<h4>Appointment Invitation</h4>
<hr>
<p>Dear {{ $data['name'] }},</p>

<p>My name is {{ Auth::user()->name }}, and I’m contacting you from KANEKA Malaysia Sdn. Bhd.
    I would like to invite you for {{ $data['appointmentPurpose'] }}.</p>

<p>Agenda : <strong>{{ $data['appointmentAgenda'] }}</strong>
    <br>Date : <strong> {{ $data['appointmentDateStart'] }} </strong>
    <br>Time : <strong> {{ $data['appointmentTime'] }} </strong>
</p>

<p>Website Link: <a href="https://vizika.online/login-user">Click here</a></p>

<p>Please login using the username and password you set during registration</p>

<p>Thank you and have a nice day.</p>

<p>Sincererly,
    <br>{{ Auth::user()->name }}
</p>