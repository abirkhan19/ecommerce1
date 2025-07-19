<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'fix_price',
        'status',
       
    ];

    public function getThresholds()
    {
        return $this->hasMany(CourierThreshold::class, 'courier_id', 'id');
    }
}
