<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function itemParentPage()
    {
        return $this->belongsTo(Page::class, 'page_id','id');
    }
    public function submenuItems()
    {
        return $this->hasMany(SubmenuItem::class);
    }
}
