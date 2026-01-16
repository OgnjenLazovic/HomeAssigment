@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Edit Room {{ $room->room_number }}</h2>

    <div class="card bg-dark text-light border-secondary">
        <div class="card-body">
            <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="room_name" class="form-label">Room Name</label>
                    <input type="text" name="room_name" class="form-control bg-secondary text-light border-secondary" value="{{ old('room_name', $room->room_name) }}">
                </div>

                <div class="mb-3">
                    <label for="floor" class="form-label">Floor</label>
                    <select name="floor" class="form-select bg-secondary text-light border-secondary">
                        @foreach(['ground','first','second','third'] as $floor)
                            <option value="{{ $floor }}" {{ $room->floor == $floor ? 'selected' : '' }}>{{ ucfirst($floor) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select bg-secondary text-light border-secondary">
                        @foreach(['available','maintenance'] as $status)
                            <option value="{{ $status }}" {{ $room->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price (€)</label>
                    <input type="number" name="price" class="form-control bg-secondary text-light border-secondary" step="0.01" value="{{ old('price', $room->price) }}">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Room Image (optional)</label>
                    <input type="file" name="image" class="form-control bg-secondary text-light border-secondary">
                </div>

                <button type="submit" class="btn btn-outline-light">Update Room</button>
            </form>
        </div>
    </div>
</div>
@endsection
