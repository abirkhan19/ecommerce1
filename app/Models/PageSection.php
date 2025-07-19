<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function myGalery()
    {
        return $this->morphMany(WithGaleryComponent::class, 'attributable');
    }

    public function myLinks()
    {
        return $this->morphMany(WithLinkComponent::class, 'attributable');
    }

    public function withImage()
    {
        return $this->morphMany(WithImageComponent::class, 'attributable');
    }

    public function pageFaq()
    {
        return $this->morphMany(PageSectionComponentFaq::class,'attributable');
    }

    public function simpleComponents()
    {
        return $this->morphMany(PageSectionComponent::class,'attributable');
    }
    
}
