<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildMenuItem extends Model
{
    use HasFactory;

    protected $guarded = [];
        
    public function childParentPage()
    {
        return $this->belongsTo(Page::class, 'page_id','id');
    }
}
