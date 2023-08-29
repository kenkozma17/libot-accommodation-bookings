<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class RoomFinderController extends Controller
{
    public function index() {
      return Inertia::render('Booking/RoomFinder');
    }
}
