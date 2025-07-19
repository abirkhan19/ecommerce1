<?php

namespace App\Livewire\Front\Components;

use Livewire\Component;

class Newsletter extends Component
{
    public $showNewsletter = true;

   
    public function mount()
    {
        $this->showNewsletter = !session()->has('newsletter.subscribed') && !session()->has('dontshow');
    
    }

    
    public function updatedShowNewsletter($value)
    {
       
        if ($value === false) {
            session()->put('dontshow', 1); 
        }
    }

    public function render()
    {
        return view('livewire.front.components.newsletter', [
            'showNewsletter' => $this->showNewsletter,
        ]);
    }


    public function subscribeToNewsletter()
    {
     
        
  
        session()->put('newsletter.subscribed', true);

  
        $this->showNewsletter = false;
    }
}
