<?php

namespace App\Livewire\Front;

use App\Models\Blog;
use Livewire\Component;

class BlogDetailsComponent extends Component
{
    public $post;
    public function mount($id)
    {
        $this->post = Blog::find($id);
    }
    public function render()
    {
        return view('livewire.front.blog-details-component',[
            'post'=>$this->post,
        ])->layout('layouts.front');
    }
}
