<!doctype html>
<html><head><title>Attendance</title></head>
<body>
<h1>Attendance Records</h1>
<table border="1">
<tr><th>User</th><th>Type</th><th>Lat</th><th>Lon</th><th>Time</th></tr>
@foreach($attendances as $a)
<tr>
<td>{{ $a->user_id }}</td>
<td>{{ $a->type }}</td>
<td>{{ $a->lat }}</td>
<td>{{ $a->lon }}</td>
<td>{{ $a->time }}</td>
</tr>
@endforeach
</table>
</body></html>
