<?php

namespace App\Livewire\Front;

use App\Models\Admin;
use Livewire\Component;
use App\Mail\WebsiteContactForm;
use Illuminate\Support\Facades\Mail;

class ContactComponent extends Component
{
    public $contactName;
    public $contactEmail;
    public $contactPhone;
    public $contactMessage;
    public $contactCaptcha;

    public function render()
    {
        return view('livewire.front.contact-component')->layout('layouts.front');
    }

    public function clearModels()
    {
        $this->contactName = '';
        $this->contactEmail = '';
        $this->contactPhone = '';
        $this->contactMessage = '';
        $this->contactCaptcha = '';
    }

    public function sendMessage()
    {
        $this->validate([
            'contactName' => 'required',
            'contactEmail' => 'required|email',
            'contactPhone' => 'required',
            'contactMessage' => 'required',
            'contactCaptcha' => 'required|captcha',
        ]);
        $to = Admin::where('role_id', 3)->first();
        if($to)
        {
            Mail::to($to->email)->send(new WebsiteContactForm($this->contactName, $this->contactEmail, $this->contactPhone, $this->contactMessage));
        }else{
            toastr()->error('Nobody wants to receive messages from this site....!');
            return;
        }

      
        $this->contactName = '';
        $this->contactEmail = '';
        $this->contactPhone = '';
        $this->contactMessage = '';
        $this->contactCaptcha = '';

        toastr()->success('Message sent successfully!');
    }

    public function regenerateCaptcha()
    {
        return captcha_img();
    }   
}
