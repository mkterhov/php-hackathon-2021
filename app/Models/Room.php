<?php

namespace App\Models;

use App\Models\Programme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    public function programmes()
    {
       return $this->hasMany(Programme::class);
    }
}
