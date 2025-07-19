<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmenuItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function childMenuItems()
    {
        return $this->hasMany(ChildMenuItem::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class,'page_id','id');
    }

    
}
