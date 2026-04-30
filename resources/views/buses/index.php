<!DOCTYPE html>
<html>
<head>
    <title>List Bus</title>
</head>
<body>

<h1>Bus List</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Route</th>
        <th>Plate</th>
        <th>Status</th>
    </tr>

    @foreach($buses as $bus)
    <tr>
        <td>{{ $bus->name }}</td>
        <td>{{ $bus->route }}</td>
        <td>{{ $bus->plate_number }}</td>
        <td>{{ $bus->status }}</td>
    </tr>
    @endforeach

</table>

</body>
</html>