<?php

namespace App\Models;

use App\Models\Programme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [  'name', 'email','programme_id', 'cnp' ];

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

}
