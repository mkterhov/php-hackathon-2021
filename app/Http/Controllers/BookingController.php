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

        // $usersOtherBookings = Booking::with('programmes')->where('cnp', $request->cnp)->get();
        $usersProgrammes = Programme::whereHas('bookings',function($query) use ($request) {
            $query->where('cnp',$request->cnp);
        })->get();
        if($usersProgrammes->where('id', $request->programme_id)->count() > 0) {
            return response()->json([
                'message'=> "User already has a booking for the event",
            ]);
        }
        $programme = Programme::withCount('bookings')->find($request->programme_id);
        // $result = DB::table('programmes')->join('bookings',function($query) use ($request) {
        //     $query->where('cnp',$request->cnp);
        // })->where('programmes.id','!=',$programme->id)->whereBetween('start_time',[ $programme->start_time, $programme->end_time])
        // ->orWhereBetween('end_time',[ $programme->start_time, $programme->end_time])->get();
        // if($result!=[]) {
        //     error_log('\n'.$usersOtherBookings.'\n');
        //     error_log('\n'.$result.'\n');

        //     return response()->json([
        //         'message'=> "User is registered for another event at the same time",
        //     ]);
        // }

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
