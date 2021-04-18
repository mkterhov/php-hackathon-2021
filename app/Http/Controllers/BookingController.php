<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Booking::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'name'=> 'required|string',
            'email' => 'required|email',
            'cnp' => 'required|regex:/^(\d{13})?$/i',
            'programme_id' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->getMessages()
            ]);
        }

        $usersOtherBookings = Booking::with('programme')->where('cnp', $request->cnp)->get();
        $programme = Programme::withCount('bookings')->find($request->programme_id);
        $usersProgrammesByTime = DB::table('programmes')
            ->join('bookings',function($join) {
                $join->on('programmes.id', '=', 'bookings.programme_id');
           })
            ->where('bookings.cnp','=', $request->cnp)
            ->where('programmes.id','IS NOT',$request->programme_id)
            ->whereBetween('programmes.start_time',[ $programme->start_time, $programme->end_time])
            ->orWhereBetween('programmes.end_time',[ $programme->start_time, $programme->end_time])
            ->get();
        if($usersOtherBookings->where('programme_id', $request->programme_id)->count() > 0) {
            return response()->json([
                'message'=> "User already has a booking for the event",
            ]);
        }
        if($usersProgrammesByTime->isNotEmpty()) {
            error_log('\n'.$usersProgrammesByTime.'\n');

            return response()->json([
                'message'=> "User is registered for another event at the same time",
            ]);
        }

        if($programme->bookings_count >= $programme->capacity) {
            return response()->json([
                'message'=> "Can't save the booking! Programme is Filled"
            ]);
        }
        $booking = Booking::create($request->all());
        return response()->json($booking);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
