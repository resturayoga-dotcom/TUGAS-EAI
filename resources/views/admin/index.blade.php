<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - City Transit</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #d2d2d2;
    margin: 0;
}

.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

/* HEADER */
.header {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    color: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.header h1 {
    margin: 0;
}

/* CARD */
.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
}

/* INPUT */
input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* BUTTON */
button {
    padding: 10px 15px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.btn-add {
    background: #2563eb;
    color: white;
}

.btn-delete {
    background: #ef4444;
    color: white;
}

/* BUS LIST */
.bus-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #eee;
}
</style>

</head>
<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h1>🚍 Admin Dashboard</h1>
        <p>Manage Bus Data</p>
    </div>

    <!-- ADD BUS -->
    <div class="card">
        <h3>➕ Tambah Bus</h3>

        <form method="POST" action="/bus">
            @csrf
            <input name="bus_number" placeholder="Bus Number" required>
            <input name="route_name" placeholder="Route Name" required>
            <input name="latitude" placeholder="Latitude" required>
            <input name="longitude" placeholder="Longitude" required>
            <input name="status" placeholder="Status (on_time / delayed)" required>

            <button class="btn-add">Tambah Bus</button>
        </form>
    </div>

    <!-- LIST BUS -->
    <div class="card">
        <h3>📋 Daftar Bus</h3>

        @foreach($buses as $bus)
        <div class="bus-item">
            <div>
                <b>Bus #{{ $bus->bus_number }}</b> <br>
                {{ $bus->route_name }} <br>
                Status: <b>{{ $bus->status }}</b>
            </div>

            <form method="POST" action="/bus/{{ $bus->id }}">
                @csrf
                @method('DELETE')
                <button class="btn-delete">Delete</button>
            </form>
        </div>
        @endforeach

    </div>

    <!-- BACK -->
    <a href="/">← Back to Home</a>

</div>

</body>
</html>