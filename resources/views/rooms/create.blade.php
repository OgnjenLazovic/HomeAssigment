@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Add New Room</h2>

    <div class="card bg-dark text-light border-secondary">
        <div class="card-body">
            <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="room_number" class="form-label">Room Number</label>
                    <input type="number" name="room_number" class="form-control bg-secondary text-light border-secondary @error('room_number') is-invalid @enderror" value="{{ old('room_number') }}">
                    @error('room_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="room_name" class="form-label">Room Name</label>
                    <input type="text" name="room_name" class="form-control bg-secondary text-light border-secondary @error('room_name') is-invalid @enderror" value="{{ old('room_name') }}">
                    @error('room_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="floor" class="form-label">Floor</label>
                    <select name="floor" class="form-select bg-secondary text-light border-secondary @error('floor') is-invalid @enderror">
                        <option value="">Select Floor</option>
                        <option value="ground" {{ old('floor') == 'ground' ? 'selected' : '' }}>Ground</option>
                        <option value="first" {{ old('floor') == 'first' ? 'selected' : '' }}>First</option>
                        <option value="second" {{ old('floor') == 'second' ? 'selected' : '' }}>Second</option>
                        <option value="third" {{ old('floor') == 'third' ? 'selected' : '' }}>Third</option>
                    </select>
                    @error('floor')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select bg-secondary text-light border-secondary @error('status') is-invalid @enderror">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price (€)</label>
                    <input type="number" name="price" class="form-control bg-secondary text-light border-secondary @error('price') is-invalid @enderror" step="0.01" value="{{ old('price') }}">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Room Image (optional)</label>
                    <input type="file" name="image" class="form-control bg-secondary text-light border-secondary @error('image') is-invalid @enderror">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-outline-light">Add Room</button>
            </form>
        </div>
    </div>
</div>
@endsection
