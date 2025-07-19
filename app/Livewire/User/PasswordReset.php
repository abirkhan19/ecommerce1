<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Mail\ResetYourPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class PasswordReset extends Component
{
    public $resetProperty;
    public $foundUser;
    public $status;

    protected $rules = [
        'resetProperty' => 'required|exists:users,email',
    ];
    public function render()
    {
        return view('livewire.user.password-reset')->layout('layouts.front');
    }

    public function sendEmailWithToken()
    {
        $this->validate();

       
        if (filter_var($this->resetProperty, FILTER_VALIDATE_EMAIL)) {
         
            $credentials = ['email' => $this->resetProperty];
            $exists = \App\Models\User::where('email', $this->resetProperty)->exists();
            $this->foundUser = User::where('email', $this->resetProperty)->first();
        } elseif (preg_match('/^\d{10,15}$/', $this->resetProperty)) {
   
            $credentials = ['phone' => $this->resetProperty];
            $exists = \App\Models\User::where('phone', $this->resetProperty)->exists();
            $this->foundUser = User::where('phone', $this->resetProperty)->first();
        } else {
           
            throw ValidationException::withMessages([
                'resetProperty' => ['Please provide a valid email or phone number.'],
            ]);
        }

        
        if (!$exists) {
            throw ValidationException::withMessages([
                'resetProperty' => ['The provided email or phone number does not exist in our records.'],
            ]);
        }else{

            $token  = Str::random(60);

            DB::table('password_resets')->insert([
                'email' => $this->foundUser->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            $this->status = 'We have emailed you a password reset link. Please check your email.';
            Session::flash('status', $this->status);
            $message = 'Click button below to reset your password';
            Mail::to($this->foundUser->email)->send(new ResetYourPassword($this->foundUser->email,$token));
        }

        
    }

    public function updatedResetProperty()
    {
        if($this->resetProperty) {
                if (filter_var($this->resetProperty, FILTER_VALIDATE_EMAIL)) {
                
                    $credentials = ['email' => $this->resetProperty];
                    $exists = \App\Models\User::where('email', $this->resetProperty)->exists();
                    $this->foundUser = User::where('email', $this->resetProperty)->first();
                } elseif (preg_match('/^\d{10,15}$/', $this->resetProperty)) {
        
                    $credentials = ['phone' => $this->resetProperty];
                    $exists = \App\Models\User::where('phone', $this->resetProperty)->exists();
                    $this->foundUser = User::where('phone', $this->resetProperty)->first();
                }
        }else{
            $this->foundUser = null;
            
        }
    }
}
