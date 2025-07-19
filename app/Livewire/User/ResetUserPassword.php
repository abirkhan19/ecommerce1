<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;
    public $passwordResetsCheck;
    public $getUser;
    
    public function mount($token,$email)
    {
        $this->token = $token;

        $this->email = $email;

        $this->passwordResetsCheck = DB::table('password_resets')->where('email', $this->email)->where('token', $this->token)->first();

        if($this->passwordResetsCheck)
        {
            $this->getUser = User::where('email', $this->email)->first();
        }
        if(!$this->getUser)
        {
            return redirect()->route('user.password-reset');
        }

    }

    public function render()
    {   

        return view('livewire.user.reset-user-password',[
            'getUser' => $this->getUser
        ])->layout('layouts.front');
    }

    public function changeUsersPassword()
    {
        $this->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $this->email)->first();

        $user->password = Hash::make($this->password);

        $user->update();
        $credentials = ['email' => $this->email, 'password' => $this->password];
        DB::table('password_resets')->where('email', $this->email)->delete();

        if (Auth::guard('web')->attempt($credentials)) {
        
            session()->regenerate();

    
            return redirect()->intended(route('front.index'));
        }

        
    }
}
