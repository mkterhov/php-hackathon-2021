<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgrammeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'room_id'=>$this->room_id,
            'nr_registered'=>$this->bookings()->count(),
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
        ];
    }
}
