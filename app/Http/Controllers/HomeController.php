<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Seat;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function detail(int $car_id)
    {
        $car = Car::find($car_id);
        return view('detail', compact('car'));
    }

    public function booking(Request $r)
    {
        BookingService::booking($r);
    }
}
