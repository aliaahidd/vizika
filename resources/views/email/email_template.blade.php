<h4>Appointment Invitation</h4>
<hr>
<p>Dear {{ $data['name'] }},</p>

<p>My name is {{ Auth::user()->name }}, and I’m contacting you from KANEKA Malaysia Sdn. Bhd.
    I would like to invite you for {{ $data['appointmentPurpose'] }}.</p>

<p>Agenda : <strong>{{ $data['appointmentAgenda'] }}</strong>
    <br>Date : <strong> {{ $data['appointmentDate'] }} </strong>
    <br>Time : <strong> {{ $data['appointmentTime'] }} </strong>
</p>

<p>Website Link: <a href="http://127.0.0.1:8000/login-user">Click this</a></p>

<p>If you are the first timer, your account has been created.</p>
<p>Email: {{ $data['email'] }}
    <br>Password: visitor123
</p>

<p>Else, you can login to your account as usual. Please login to choose whether you can attend or not as soon as possible.</p>

<p>Thank you. Have a nice day.</p>

<p>Sincererly,
    <br>{{ Auth::user()->name }}
</p>