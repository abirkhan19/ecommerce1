<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class RegisterComponent extends Component
{
    use WithFileUploads;

    public $userName;
    public $loginPassword;
    public $rememberMe=false;

    //Register variables 
    public $imagePath='front/images/users/';
    public $profileImage='noimage.png';
    public $profileImageInput;
    public $registerUsername;
    public $password;
    public $password_confirmation;
    public $registerPhoneNumber;
    public $registerEmail;
    public $capthcaText;
    
    public function render()
    {
        return view('livewire.user.register-component')->layout('layouts.front');
    }

    public function authenticateUser()
    {
       
         $this->validate([
            'userName' => 'required|string',
            'loginPassword' => 'required|string',
            
        ]);

    
        $credentials = ['password' => $this->loginPassword];

        if (filter_var($this->userName, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $this->userName;
        } else {
            $credentials['phone_number'] = $this->userName;
        }

        
        if (Auth::guard('web')->attempt($credentials, $this->rememberMe)) {
        
            session()->regenerate();

    
            return redirect()->intended(route('front.index'));
        }

       
        $this->addError('userName', 'The provided credentials do not match our records.');
    }

    public function updatedProfileImageInput()
    {
        if($this->profileImage){
            $this->validate([
                'profileImageInput' => 'image|max:1024|mimes:jpg,png,svg,bmp,jpeg,gif', // 1MB Max
            ]);

            if($this->registerEmail)
            {
                $imageName = $this->profileImageInput->getClientOriginalName();
                $dirPath = 'front/images/users/'.$this->registerEmail.'/';
                $path = $dirPath.'/'.$imageName;

                $this->imagePath = $dirPath;

                if(!file_exists($dirPath)){
                    mkdir($dirPath, 0777, true);
                }
                $this->imagePath = $dirPath;
                Image::make($this->profileImageInput)->resize(300, 300)->save($path);
                $this->profileImage = $imageName;
            }else{
                $imageName = $this->profileImageInput->getClientOriginalName();
                $dirPath = 'front/images/users/';
                $path = $dirPath.'/'.$imageName;
                $this->imagePath = $dirPath;
                if(!file_exists($dirPath)){
                    mkdir($dirPath, 0777, true);
                }
                Image::make($this->profileImageInput)->resize(300, 300)->save($path);
                $this->profileImage = $imageName;
            }

        }
    }

    public function registerUser()
    {
        $this->validate([
            'registerUsername' => 'required|string',
            'password' => 'required|string|confirmed',
            'registerPhoneNumber' => 'required|string|unique:users,phone',
            'registerEmail' => 'required|email|unique:users,email',
            'capthcaText' => 'required|captcha'
           
        ]);

        $user = new User();
        $user->name = $this->registerUsername;
        $user->email = $this->registerEmail;
        $user->phone = $this->registerPhoneNumber;
        $user->password = Hash::make($this->password);
        $user->photo = $this->profileImage;
        $user->save();
        $credentials = ['password' => $this->password, 'email' => $this->registerEmail];
      
        if (Auth::guard('web')->attempt($credentials)) {
          
            session()->regenerate();
            if($this->profileImage !=='noimage.png' && $this->profileImageInput)
            {
                  $sourcePath = 'front/images/users/'.$this->profileImage; // File in the 'users' directory
                  $destinationPath = 'front/images/users/'.$this->registerEmail.'/'.$this->profileImage; // File should be moved to the 'user/email' directory

      
                    if (!File::exists('front/images/users/'.$this->registerEmail)) {
                    
                            if(File::makeDirectory('front/images/users/'.$this->registerEmail.'', 0777, true))
                            {
                                File::move($sourcePath, $destinationPath);
                            }
                    }
       
            }

        return redirect()->intended(route('front.index'));
        
        }
    }

    public function regenerateCaptcha()
    {
        return captcha_img();
    }
}
