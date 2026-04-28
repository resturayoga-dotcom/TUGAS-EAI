<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Transit Tracker</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        /* Base Reset & Typography */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f4f7f6; 
            color: #333;
            line-height: 1.6;
        }

        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }

        /* Header */
        header { margin-bottom: 30px; }
        header h1 { color: #2c3e50; font-size: 2rem; }
        header p { color: #7f8c8d; }

        /* Layout Grid */
        .dashboard {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 20px;
        }

        /* Sidebar Styling */
        .sidebar {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-height: 600px;
            overflow-y: auto;
        }

        .bus-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin-bottom: 15px;
            background: #fcfcfc;
            border-radius: 6px;
            border-left: 5px solid #2ecc71; /* Green for on-time */
            transition: transform 0.2s;
        }

        .bus-card.delayed { border-left-color: #e74c3c; }
        .bus-card:hover { transform: translateX(5px); }

        .bus-info h4 { margin: 0; font-size: 1.1rem; color: #34495e; }
        .bus-info p { font-size: 0.85rem; color: #95a5a6; }

        /* Status Badges */
        .badge {
            font-size: 0.7rem;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 12px;
            text-transform: uppercase;
        }
        .badge-ontime { background: #eafaf1; color: #2ecc71; }
        .badge-delayed { background: #fdedec; color: #e74c3c; }

        /* Map Area */
        .map-container {
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        #map { height: 580px; width: 100%; border-radius: 4px; }

        /* Responsive Logic */
        @media (max-width: 900px) {
            .dashboard { grid-template-columns: 1fr; }
            .sidebar { max-height: none; }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>City Transit Live</h1>
        <p>Monitoring active bus routes and schedules</p>
    </header>

    <div class="dashboard">
        <aside class="sidebar">
            <h3 style="margin-bottom: 15px;">Live Fleet</h3>
            @foreach($buses as $bus)
            <div class="bus-card {{ $bus->status == 'delayed' ? 'delayed' : '' }}">
                <div class="bus-info">
                    <h4>Bus #{{ $bus->bus_number }}</h4>
                    <p>{{ $bus->route_name }}</p>
                </div>
                <span class="badge {{ $bus->status == 'delayed' ? 'badge-delayed' : 'badge-ontime' }}">
                    {{ str_replace('_', ' ', $bus->status) }}
                </span>
            </div>
            @endforeach
        </aside>

        <main class="map-container">
            <div id="map"></div>
        </main>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Map setup
    const map = L.map('map').setView([-6.1754, 106.8272], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // Inject PHP data into JS
    const buses = @json($buses);

    buses.forEach(bus => {
        L.marker([bus.latitude, bus.longitude])
            .addTo(map)
            .bindPopup(`<b>Bus ${bus.bus_number}</b><br>${bus.route_name}`);
    });
</script>

</body>
</html>