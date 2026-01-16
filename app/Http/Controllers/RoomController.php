<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Services\GoogleCalendarService;

class RoomController extends Controller
{

    public function index(Request $request)
    {
        $query = Room::query();
        if ($request->filled('floor')) {
            $query->where('floor', $request->floor);
        }


        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('room_name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('room_name', 'desc');
                    break;
            }
        }

        $rooms = $query->get();

        return view('home', compact('rooms'));
    }


    public function create()
    {
        return view('rooms.create');
    }


    public function store(Request $request, GoogleCalendarService $calendar)
    {

        $request->validate([
            'room_number' => 'required|integer|unique:rooms',
            'room_name' => 'required|string|max:255',
            'floor' => 'required|in:ground,first,second,third',
            'status' => 'required|in:available,booked,maintenance',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $googleCalendar = $calendar->createCalendar('Room ' . $request->room_number);
           

        $room = Room::create([
            'room_number' => $request->room_number,
            'room_name' => $request->room_name,
            'floor' => $request->floor,
            'status' => $request->status,
            'price' => $request->price,
            'image' => $request->file('image')?->store('rooms', 'public'),
            'calendar_id' => $googleCalendar->id,

        ]);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully!');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_name' => 'required|string|max:255',
            'floor' => 'required|in:ground,first,second,third',
            'status' => 'required|in:available,booked,maintenance',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $room->image = $request->file('image')->store('rooms', 'public');
        }

        $room->update($request->only(['room_name', 'floor', 'status', 'price']));

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully!');
    }


    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully!');
    }
}
