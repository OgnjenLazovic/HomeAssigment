<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palazzo de la Sengle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<nav class="navbar navbar-dark bg-dark border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold" href="#">Palazzo de la Sengle</a>

        <ul class="navbar-nav flex-row gap-3 align-items-center">
            @guest
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('register') }}">Register</a>
                </li>
            @else
                <li class="nav-item">
                    <span class="nav-link text-light">
                        Hello, {{ auth()->user()->name }}
                    </span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-link nav-link text-light p-0" type="submit">
                            Logout
                        </button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>

<div class="container my-5">

    
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-4">Rooms</h2>
    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="mb-4 text-end">
        <a href="{{ route('rooms.create') }}" class="btn btn-outline-light">
            Add New Room
        </a>
    </div>
@endif

    </div>
    <form method="GET" action="{{ route('rooms.index') }}">
        <div class="card bg-dark text-light border-secondary mb-4 p-3">
            <div class="row gx-3 gy-2 align-items-end">


                <div class="col-auto">
                    <label for="floor" class="form-label">Floor</label>
                    <select name="floor" id="floor" class="form-select bg-secondary text-light border-secondary">
                        <option value="">All Floors</option>
                        <option value="ground" {{ request('floor') == 'ground' ? 'selected' : '' }}>Ground</option>
                        <option value="first" {{ request('floor') == 'first' ? 'selected' : '' }}>First</option>
                        <option value="second" {{ request('floor') == 'second' ? 'selected' : '' }}>Second</option>
                        <option value="third" {{ request('floor') == 'third' ? 'selected' : '' }}>Third</option>
                    </select>
                </div>


                <div class="col-auto">
                    <label class="form-label">Price Range (€)</label>
                    <div class="d-flex gap-2">
                        <input type="number" name="min_price" class="form-control bg-secondary text-light border-secondary" placeholder="Min" value="{{ request('min_price') }}">
                        <input type="number" name="max_price" class="form-control bg-secondary text-light border-secondary" placeholder="Max" value="{{ request('max_price') }}">
                    </div>
                </div>


                <div class="col-auto">
                    <label for="sort" class="form-label">Sort By</label>
                    <select name="sort" id="sort" class="form-select bg-secondary text-light border-secondary">
                        <option value="">Default</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price ↑</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price ↓</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                    </select>
                </div>


                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-light">Filter</button>
                </div>

            </div>
        </div>
    </form>


        <div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach($rooms as $room)
        <div class="col">
            <div class="card h-100 bg-secondary text-light border-0 shadow">
                
                
                <img src="{{ $room->image ? asset('storage/' . $room->image) : asset('storage/rooms/placeholder.jpg') }}" 
                     class="card-img-top" alt="Room Image">

                <div class="card-body">
                    <h5 class="card-title">Room {{ $room->room_number }}</h5>
                    <p class="card-text">
                        Name: {{ $room->room_name }}<br>
                        Floor: {{ ucfirst($room->floor) }}<br>
                        Price: €{{ number_format($room->price, 2) }}<br>
                        Status:
                        @if($room->status === 'available')
                            <span class="badge bg-success">Available</span>
                            <div class="mt-2">
                                <a href="{{ route('bookings.create', $room->id) }}" class="btn btn-sm btn-outline-light">
                                    Book Now
                                </a>
                            </div>
                        @elseif($room->status === 'booked')
                            <span class="badge bg-danger">Booked</span>
                        @else
                            <span class="badge bg-warning text-dark">Maintenance</span>
                        @endif
                    </p>
                </div>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="card-footer bg-dark text-end border-top border-secondary">
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-outline-light">
                            Edit
                        </a>
                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
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
