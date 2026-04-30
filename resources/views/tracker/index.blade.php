<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Transit Tracker</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
       <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background: #d2d2d2;
            color: #1a237e;
            line-height: 1.6;
            min-height: 100vh;
        }

        .container { max-width: 1400px; margin: 0 auto; padding: 24px; }

        /* Header */
        header { 
            margin-bottom: 32px;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        header h1 { 
            color: #ffffff; 
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        header p { 
            color: #e0e7ff;
            font-size: 1.1rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            padding: 16px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }
        .stat-card i { 
            font-size: 1.5rem; 
            color: #ffffff; 
            margin-bottom: 6px; 
        }
        .stat-card .number { 
            font-size: 1.5rem; 
            font-weight: 700; 
            color: #ffffff;
        }
        .stat-card .label { 
            font-size: 0.8rem; 
            color: #dbeafe;
            margin-top: 3px; 
        }

        /* Layout Grid */
        .dashboard {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 24px;
        }

        /* Sidebar Styling */
        .sidebar {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-height: 650px;
            overflow-y: auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar h3 { 
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Bus Card */
        .bus-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            border-left: 4px solid #60a5fa;
            transition: all 0.3s ease;
            cursor: pointer;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .bus-card:hover { 
            transform: translateX(8px);
            box-shadow: 0 4px 12px rgba(96, 165, 250, 0.3);
            background: rgba(255, 255, 255, 0.25);
        }

        .bus-card.delayed { 
            border-left-color: #ef4444;
            background: rgba(239, 68, 68, 0.15);
        }
        .bus-card.delayed:hover {
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            background: rgba(239, 68, 68, 0.25);
        }

        .bus-info {
            flex: 1;
        }
        .bus-info h4 { 
            margin: 0; 
            font-size: 0.95rem; 
            color: #ffffff;
            font-weight: 600;
        }
        .bus-info p { 
            font-size: 0.75rem; 
            color: #dbeafe;
            margin-top: 2px;
        }

        /* Status Badges */
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-ontime { 
            background: rgba(34, 197, 94, 0.3);
            color: #86efac;
            border: 1px solid #22c55e;
        }
        .badge-delayed { 
            background: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border: 1px solid #ef4444;
        }

        /* Map Area */
        .map-container {
            background: #ffffff;
            padding: 12px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        #map { 
            height: 650px; 
            width: 100%; 
            border-radius: 8px;
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .dashboard { grid-template-columns: 1fr; }
            .sidebar { max-height: none; }
            #map { height: 500px; }
        }

        @media (max-width: 768px) {
            header { padding: 20px; }
            header h1 { font-size: 1.8rem; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .container { padding: 16px; }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1><i class="fas fa-bus"></i> City Transit Live</h1>
        <p>Real-time monitoring of active bus routes and schedules</p>
    </header>

    <div style="margin-bottom: 20px; text-align: right;">

    @auth
        @if(auth()->user()->role === 'admin')
            <a href="/admin">Admin Panel</a> |
        @endif

        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button style="background:none;border:none;color:red;cursor:pointer;">
                Logout
            </button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a> |
        <a href="{{ route('register') }}">Register</a>
    @endauth

</div>

    <!-- Stats Section -->
    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-bus-alt"></i>
            <div class="number">{{ count($buses) }}</div>
            <div class="label">Active Buses</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-check-circle"></i>
            <div class="number">{{ count(array_filter($buses->toArray(), fn($b) => $b['status'] != 'delayed')) }}</div>
            <div class="label">On Time</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-exclamation-circle"></i>
            <div class="number">{{ count(array_filter($buses->toArray(), fn($b) => $b['status'] == 'delayed')) }}</div>
            <div class="label">Delayed</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-route"></i>
            <div class="number">12</div>
            <div class="label">Total Routes</div>
        </div>
    </div>

    <div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h3><i class="fas fa-list"></i> Live Fleet</h3>

        @auth
        @if(auth()->user()->role === 'admin')

        <!-- ADD BUS -->
        <div style="background:rgba(255,255,255,0.2); padding:10px; border-radius:8px; margin-bottom:15px;">
            <form method="POST" action="/bus">
                @csrf

                <input type="text" name="bus_number" placeholder="Bus No" required style="width:100%; margin-bottom:5px;">
                <input type="text" name="route_name" placeholder="Route" required style="width:100%; margin-bottom:5px;">
                <input type="text" name="latitude" placeholder="Lat" required style="width:100%; margin-bottom:5px;">
                <input type="text" name="longitude" placeholder="Lng" required style="width:100%; margin-bottom:5px;">

                <select name="status" style="width:100%; margin-bottom:5px;">
                    <option value="on_time">On Time</option>
                    <option value="delayed">Delayed</option>
                </select>

                <button style="width:100%; background:#22c55e; border:none; padding:6px; color:white;">
                    + Add
                </button>
            </form>
        </div>

        @endif
        @endauth


        <!-- LIST BUS -->
        @foreach($buses as $bus)
        <div class="bus-card {{ $bus->status == 'delayed' ? 'delayed' : '' }}">

            <div class="bus-info">
                <h4>Bus #{{ $bus->bus_number }}</h4>
                <p>{{ $bus->route_name }}</p>
            </div>

            <span class="badge {{ $bus->status == 'delayed' ? 'badge-delayed' : 'badge-ontime' }}">
                {{ str_replace('_', ' ', $bus->status) }}
            </span>

            @auth
            @if(auth()->user()->role === 'admin')

            <div style="display:flex; flex-direction:column; gap:4px; margin-left:8px;">

                <!-- EDIT -->
                <form method="POST" action="/bus/{{ $bus->id }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="bus_number" value="{{ $bus->bus_number }}">
                    <input type="hidden" name="route_name" value="{{ $bus->route_name }}">
                    <input type="hidden" name="latitude" value="{{ $bus->latitude }}">
                    <input type="hidden" name="longitude" value="{{ $bus->longitude }}">
                    <input type="hidden" name="status" value="{{ $bus->status }}">

                    <button style="background:#f59e0b;color:white;border:none;padding:4px;">
                        Edit
                    </button>
                </form>

                <!-- DELETE -->
                <form method="POST" action="/bus/{{ $bus->id }}">
                    @csrf
                    @method('DELETE')

                    <button style="background:#ef4444;color:white;border:none;padding:4px;">
                        Del
                    </button>
                </form>

            </div>

            @endif
            @endauth

        </div>
        @endforeach
    </aside>


    <!-- MAP -->
    <main class="map-container">
        <div id="map"></div>
    </main>

</div>
</div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([-6.1754, 106.8272], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const buses = @json($buses);
    buses.forEach(bus => {
        L.marker([bus.latitude, bus.longitude])
            .addTo(map)
            .bindPopup(`<b>Bus ${bus.bus_number}</b><br>${bus.route_name}`);
    });
</script>

</body>
</html>