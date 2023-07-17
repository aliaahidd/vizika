<h4>User Pending Approval</h4>
<hr>
<p>Dear {{ $data['name'] }},</p>

<p>The user under your recommendation is waiting for your approval.</p>

<p>Name : <strong>{{ Auth::user()->name }}</strong>
    <br>Email : <strong> {{ Auth::user()->email }} </strong>
    <br>User Type : <strong> {{ Auth::user()->category }} </strong>
</p>

<p>Thank you and have a nice day.</p>