<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Services\GoogleCalendarService;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Room $room)
    {
        return view('bookings.create', compact('room'));
    }

    public function store(Request $request, Room $room, GoogleCalendarService $calendar)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $check_in = Carbon::parse($request->check_in);
        $check_out = Carbon::parse($request->check_out);


        if (!$calendar->checkAvailability($room->calendar_id, $check_in, $check_out)) {
            return back()->with('error', 'Room is already booked for this period.');
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'room_id' => $room->id,
            'check_in' => $check_in,
            'check_out' => $check_out,
        ]);


        $calendar->createEvent($room->calendar_id, $booking);

        return redirect()->route('home')->with('success', 'Booking confirmed!');
    }
    

}

