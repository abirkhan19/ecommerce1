<?php

namespace App\Livewire\Front;

use Livewire\Component;

class BlogComponent extends Component
{
    public function render()
    {
        return view('livewire.front.blog-component')->layout('layouts.front');
    }
}
