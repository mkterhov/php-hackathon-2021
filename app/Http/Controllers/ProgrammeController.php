<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgrammeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Programme::with(['bookings'])->get();
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
            'title'=> 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'date|after:start_time',
            'capacity' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first()
            ]);
        }
        $room = Room::find($request->room_id);
        //check if room exists
        if(!$room) {
            return response()->json([
                'message' => 'No room with the id=' . $request->room_id . ' found!',
            ],400);
        }
        $programmesByTimeInterval =  Programme::select('*')
            ->where('room_id','=', $request->room_id)
            ->whereBetween('start_time',[ $request->start_time, $request->end_time])
            ->orWhereBetween('end_time',[ $request->start_time, $request->end_time])
            ->get();
        if($programmesByTimeInterval->isNotEmpty()) {
            error_log('\n'.$programmesByTimeInterval.'\n');

            return response()->json([
                'message'=> "Event already taking place in the same room during the period given!",
            ]);
        }

        $programme = Programme::create($request->all());
        return response()->json($programme);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function show(Programme $programme)
    {
        return $programme;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function edit(Programme $programme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Programme $programme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Programme $programme)
    {
        if($programme->delete()) {
            return response()->json($programme);
        }
        return response()->json(["Error"=> "Couldn't delete the record"]);
    }
}
