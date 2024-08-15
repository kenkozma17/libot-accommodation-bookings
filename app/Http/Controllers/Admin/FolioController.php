<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FolioTransaction;
use Illuminate\Http\Request;
use App\Http\Requests\FolioStoreRequest;
use Inertia\Inertia;
use App\Models\Folio;
use App\Models\Guest;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceCategory;
use Carbon\Carbon;
use Exception;

class FolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $folios = Folio::where([
            [function ($query) use ($request) {
              if (($s = $request->search)) {
                $query->where('registration_number', 'LIKE', '%' . $s . '%')
                  ->get();
              }
            }]
          ])->orWhereHas('guest', function ($query) use ($request) {
            if (($s = $request->search)) {
              $query->where('first_name', 'LIKE', '%' . $s . '%' )
                ->orWhere('last_name', 'LIKE', '%' . $s . '%')
                ->orWhere('email', 'LIKE', '%' . $s . '%');
            }
          })->orWhereHas('booking', function ($query) use ($request) {
            if (($s = $request->search)) {
              $query->where('booking_confirmation', 'LIKE', '%' . $s . '%');
            }
          })
          ->with('guest', 'booking')
          ->orderBy('created_at', 'asc')
          ->paginate(config('pagination.default'))
          ->withQueryString();

        return Inertia::render('Admin/Folios/FoliosList', [
            'folios' => $folios,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Folios/Create', [
            'guests' => Guest::orderBy('last_name', 'asc')->get(),
            'bookings' => Booking::where('booking_status', 'CONFIRMED')
                ->where('check_out', '>=', Carbon::today())
                ->orderBy('check_in', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FolioStoreRequest $request)
    {
        // try {
            // Create the Folio
            $folio = new Folio;
            $folio->registration_number = $this->generateRegNumber();
            if( $request->guest_id !== 0) {
                $folio->guest_id = $request->guest_id;
            }
            if($request->booking_id !== 0) {
                $folio->booking_id = $request->booking_id;
            }
            $folio->save();

            session()->flash('flash.banner', 'Folio Created Successfully!');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('folios.index');
        // } catch(Exception $ex) {

        // }
    }

    public function generateRegNumber() {
        $latestFolio = Folio::latest('created_at')->first();
        if($latestFolio) {
            return (string) (((int) $latestFolio->registration_number) + 1);
        }
        return '5000';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $folio = Folio::with(['booking', 'guest'])->where('id', $id)->first();
        $serviceCategories = ServiceCategory::with('services')->orderBy('name', 'asc')->get();
        return Inertia::render('Admin/Folios/Show', [
            'folio' => $folio,
            'serviceCategories' => $serviceCategories,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
