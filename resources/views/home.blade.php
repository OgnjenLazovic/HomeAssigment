<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo de la Sengle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Palazzo de la Sengle</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <span class="nav-link">Hello, {{ auth()->user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">

        <h2 class="mb-4">Rooms</h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($rooms as $room)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Room {{ $room->room_number }}</h5>
                            <p class="card-text">
                                Type: {{ ucfirst($room->room_type) }}<br>
                                Price: ${{ number_format($room->price, 2) }}<br>
                                Status: 
                                @if($room->status == 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif($room->status == 'booked')
                                    <span class="badge bg-danger">Booked</span>
                                @else
                                    <span class="badge bg-warning text-dark">Maintenance</span>
                                @endif
                            </p>
                        </div>

                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <div class="card-footer text-end">
                                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
