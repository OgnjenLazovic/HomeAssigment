<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::all(); // get all rooms
        return view('home', compact('rooms')); // pass to Blade
    }
}
