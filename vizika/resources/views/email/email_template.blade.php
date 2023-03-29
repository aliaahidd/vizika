<p>Dear {{ $data['name'] }},</p>

<p>My name is {{ Auth::user()->name }}, and I’m contacting you from KANEKA Malaysia Sdn. Bhd.
    I would like to invite you to {{ $data['appointmentPurpose'] }}.</p>

<p>Subject : {{ $data['appointmentName'] }}
    <br>Date : {{ $data['appointmentDate'] }}
    <br>Time : {{ $data['appointmentTime'] }}
</p>

<p>If you are the first timer, your account has been created.</p>
<p> link: <a href="http://127.0.0.1:8000/login">Click this link</a></p>

<p>Email: {{ $data['email'] }}
    <br>Password: visitor123
</p>

<p>Else, you can login to your account as usual for further details. </p>

<p>Thank you. Have a nice day.</p>

<p>Sincererly,
    <br>{{ Auth::user()->name }}
</p>