<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Tracker</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { font-family: sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { display: flex; gap: 20px; max-width: 1200px; margin: auto; }
        .sidebar { width: 300px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .map-box { flex-grow: 1; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        #map { height: 500px; width: 100%; border-radius: 5px; }
        .bus-item { padding: 10px; border-bottom: 1px solid #eee; }
        .status { font-weight: bold; font-size: 12px; padding: 3px 8px; border-radius: 10px; }
        .on_time { background: #d4edda; color: #155724; }
        .delayed { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

    <h2 style="text-align:center;">Sistem Pelacak Bus Real-Time</h2>

    <div class="container">
        <div class="sidebar">
            <h3>Daftar Bus</h3>
            @if($buses->isEmpty())
                <p>Tidak ada bus aktif.</p>
            @else
                @foreach($buses as $bus)
                <div class="bus-item">
                    <strong>{{ $bus->bus_number }}</strong><br>
                    <small>{{ $bus->route_name }}</small><br>
                    <span class="status {{ $bus->status }}">{{ strtoupper($bus->status) }}</span>
                </div>
                @endforeach
            @endif
        </div>

        <div class="map-box">
            <div id="map"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Koordinat awal (Jakarta)
        var map = L.map('map').setView([-6.2088, 106.8456], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Ambil data dari Laravel ke JavaScript
        var buses = @json($buses);

        buses.forEach(function(bus) {
            L.marker([bus.latitude, bus.longitude])
                .addTo(map)
                .bindPopup("<b>Bus " + bus.bus_number + "</b><br>" + bus.route_name);
        });
    </script>
</body>
</html>