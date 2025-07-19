<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierThreshold extends Model
{
    use HasFactory;

    protected $fillable = [
        'courier_id',
        'low_threshold',
        'high_threshold',
        'price',
        'status',
    ];
}
