@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h3>Book Room {{ $room->room_number }}</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('bookings.store', $room->id) }}">
        @csrf

        <div class="mb-3">
            <label for="check_in" class="form-label">Check-in</label>
            <input type="datetime-local" class="form-control" name="check_in" required>
        </div>

        <div class="mb-3">
            <label for="check_out" class="form-label">Check-out</label>
            <input type="datetime-local" class="form-control" name="check_out" required>
        </div>

        <button type="submit" class="btn btn-primary">Book Now</button>
    </form>
</div>
@endsection
