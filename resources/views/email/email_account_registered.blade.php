<h4>Registration for Kaneka Account</h4>
<hr>
<p>Dear {{ $data['name'] }},</p>

<p>Please go to the website link below and register an account. This account is needed to get authorization to visit/enter Kaneka.</p>

<p>Website Link: <a href="https://vizika.online/register-external-user?name={{ urlencode($data['name']) }}&email={{ $data['email'] }}&category={{ urlencode($data['category'])}}">Click here</a></p>

<p>Thank you and have a nice day.</p>