<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Programme;
use Illuminate\Http\Request;
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
            // 'cnp' => 'required|regex:/^(\d{13})?$/i',
            'cnp' => ['required','regex:/^[1-8]\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])(0[1-9]|[1-4]\d|5[0-2]|99)\d{4}$/'],
            'programme_id' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->getMessages()
            ]);
        }

        $programme = Programme::withCount('bookings')->find($request->programme_id);
        //check if programme exists
        if(!$programme) {
            return response()->json([
                'message' => 'No Programme with the id=' . $request->programme_id . ' found!',
            ],400);
        }
        //check if user is signed up for the programme that the request tries to register
        $usersOtherBookings = Booking::with('programme')->where('cnp', $request->cnp)->get();
        if($usersOtherBookings->where('programme_id', $request->programme_id)->count() > 0) {
            return response()->json([
                'message'=> "User already has a booking for the event",
            ]);
        }
        //checks wheather there are any programmes that user has that overlap with this one
        $usersProgrammesByTime = \DB::table('programmes')
            ->join('bookings',function($join) {
                $join->on('programmes.id', '=', 'bookings.programme_id');
           })
            ->where('bookings.cnp','=', $request->cnp)
            ->where('programmes.id','IS NOT',$request->programme_id)
            ->whereBetween('programmes.start_time',[ $programme->start_time, $programme->end_time])
            ->orWhereBetween('programmes.end_time',[ $programme->start_time, $programme->end_time])
            ->get();
        if($usersProgrammesByTime->isNotEmpty()) {
            return response()->json([
                'message'=> "User is registered for another event at the same time",
            ]);
        }
        //check if the programme has capacity
        if($programme->bookings_count >= $programme->capacity) {
            return response()->json([
                'message'=> "Can't save the booking! Programme is Filled"
            ]);
        }
        //register the user
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
