<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingService
{
    public static function booking(Request $r)
    {
        $seats = Seat::where('car_id', $r->car_id)->get();
        foreach ($seats as $seat) {
            if($seat->seat_number != null) {
                if(in_array($seat->seat_number, $r->checked)) {
                    $seat->user_id = Auth::id();
                    $seat->save();
                }
            }
        }
        return response()->json(200);
    }
}
