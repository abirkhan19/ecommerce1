<?php

namespace App\Livewire\Front;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Courier;
use App\Models\Product;
use Livewire\Component;
use App\Models\Currency;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Models\Generalsetting;
use App\Models\CompanyCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use App\Livewire\Front\Components\Dispatcher;
use App\Http\Controllers\StripePaymentController;

class CheckoutComponent extends Component
{ 
    use WithFileUploads;
    //User login vars 
    public $loginName, $loginPassword;
    //User register vars
    public $getProfilePhoto='noimage.png',$dirPath='front/images/users/';
    public $fullName, 
    $emailAddress,
    $profilePhoto,
    $phoneNumber,
    $password, 
    $password_confirmation;
    //forms setter 
    public $selectedShippingMethodPrice=0.00;
    public $billingAddressOpen=true, $shippingAddressOpen=false, $shippingMethodOpen=false, $paymentMethodOpen=false, $orderReviewOpen=false;
    //billing address vars
    public $billingName, $billingLastName, $billingEmail, $billingPhone, $billingAddress, $billingCity, $billingState, $billingZip,$billingProvince;
    //shipping address vars
    public $identifyPerson = 'physicalPerson';

    //company form 
    public $sendInfo=false,$companyProvince,$taxPayment,$companyFormOpen=false,$companyFiscal,$administratorName,$companyContact,$companyIdentification, $companyName, $companyEmail, $companyPhone, $companyAddress, $companyCity, $companyState, $companyZip;

    public $receiverFax, $receiverName, $shippingEmail, $shippingPhone, $shippingAddress, $shippingCity, $shippingState, $shippingZip, $shippingMentions;

    public $shippingMethodName, $courierId,$shippingOptions = [],$getCouriers = [];

    public $defaultState,$getStates = [];

    //payment method vars
    public $paymentMethodName;
    //cart vars
    public $cartItems = [];

    public $formatedTotal = 0;

    public $totalQuantity=0;

    public $productTotal;

    public $productQuantity;

    public $paymentStatus;
    
    public function mount()
    {        
       
       if(Auth::guard('web')->check()){
            $this->billingName = Auth::guard('web')->user()->name;
            $this->billingEmail = Auth::guard('web')->user()->email;
            $this->billingPhone = Auth::guard('web')->user()->phone;
            $this->billingName = session()->has('billingName') ? session()->get('billingName') : $this->billingName;
            $this->billingLastName = session()->has('billingLastName') ? session()->get('billingLastName') : $this->billingLastName;
            $this->billingEmail = session()->has('billingEmail') ? session()->get('billingEmail') : $this->billingEmail;
            $this->billingPhone = session()->has('billingPhone') ? session()->get('billingPhone') : $this->billingPhone;
        }    
        else{
            $this->billingName = session()->has('billingName') ? session()->get('billingName') : '';
            $this->billingLastName = session()->has('billingLastName') ? session()->get('billingLastName') : '';
            $this->billingEmail = session()->has('billingEmail') ? session()->get('billingEmail') : '';
            $this->billingPhone = session()->has('billingPhone') ? session()->get('billingPhone') : '';
        }
        $this->billingAddress = session()->has('billingAddress') ? session()->get('billingAddress') : '';
        $this->billingCity = session()->has('billingCity') ? session()->get('billingCity') : '';
        $this->billingState = session()->has('billingState') ? session()->get('billingState') : '';
        $this->billingZip = session()->has('billingZip') ? session()->get('billingZip') : '';
        $this->billingProvince = session()->has('billingProvince') ? session()->get('billingProvince') : '';
        $this->companyFiscal = session()->has('companyFiscal') ? session()->get('companyFiscal') : '';
        $this->identifyPerson = session()->has('personIdenfity') ? session()->get('personIdenfity') : 'physicalPerson';
        $this->companyIdentification = session()->has('companyIdentification') ? session()->get('companyIdentification') : '';
        $this->companyName = session()->has('companyName') ? session()->get('companyName') : '';
        $this->companyEmail = session()->has('companyEmail') ? session()->get('companyEmail') : '';
        $this->companyPhone = session()->has('companyPhone') ? session()->get('companyPhone') : '';
        $this->companyAddress = session()->has('companyAddress') ? session()->get('companyAddress') : '';
        $this->companyCity = session()->has('companyCity') ? session()->get('companyCity') : '';
        $this->companyState = session()->has('companyState') ? session()->get('companyState') : '';
        $this->companyZip = session()->has('companyZip') ? session()->get('companyZip') : '';
        $this->companyProvince = session()->has('companyProvince') ? session()->get('companyProvince') : '';
        $this->companyFormOpen = session()->has('companyFormOpen') ? session()->get('companyFormOpen') : false;
        $this->administratorName = session()->has('administratorName') ? session()->get('administratorName') : '';
        $this->companyContact = session()->has('companyContact') ? session()->get('companyContact') : '';
        $this->taxPayment = session()->has('taxPayment') ? session()->get('taxPayment') : false;
        $this->sendInfo = session()->has('sendInfo') ? session()->get('sendInfo') : false;
        $this->billingAddressOpen = session()->has('billingAddressOpen') ? true : false;
        
        //Billing address information ends here
        $this->shippingAddressOpen = session()->has('shippingAddressOpen') ? true : false;
        $this->receiverName = session()->has('receiverName') ? session()->get('receiverName') : '';        
        $this->shippingEmail = session()->has('shippingEmail') ? session()->get('shippingEmail') : '';
        $this->shippingPhone = session()->has('shippingPhone') ? session()->get('shippingPhone') : '';
        $this->shippingAddress = session()->has('shippingAddress') ? session()->get('shippingAddress') : '';
        $this->shippingCity = session()->has('shippingCity') ? session()->get('shippingCity') : '';
        $this->shippingState = session()->has('shippingState') ? session()->get('shippingState') : '';
        $this->shippingZip = session()->has('shippingZip') ? session()->get('shippingZip') : '';
        $this->receiverFax = session()->has('receiverFax') ? session()->get('receiverFax') : '';
        $this->shippingMentions = session()->has('shippingMentions') ? session()->get('shippingMentions') : '';

        //End shipping method information
        $this->shippingMethodOpen = session()->has('shippingMethodOpen') ? true : false;
        $this->shippingMethodName = session()->has('shippingMethodName') ? session()->get('shippingMethodName') : '';
        $this->selectedShippingMethodPrice = session()->has('selectedShippingMethodPrice') ? session()->get('selectedShippingMethodPrice') : 0.00;
        $this->courierId = session()->has('courierId') ? session()->get('courierId') : '';
        $this->shippingOptions = Shipping::all();
        //payment method informations
        $this->paymentMethodOpen = session()->has('paymentMethodOpen') ? true : false;
        $this->paymentMethodName = session()->has('paymentMethodName') ? session()->get('paymentMethodName') : '';
        $this->orderReviewOpen = session()->has('orderReviewOpen') ? true : false;
        //cart items
        $this->cartItems = session()->has('cart.items') ? session()->get('cart.items') : [];
        $total  = 0;
        foreach($this->cartItems as $item)
        {
            $total += $item['original_price'] * $item['quantity'];
            
        }
        $this->formatedTotal = $total;

        $generalSetting = Generalsetting::find(1);
        if(!$generalSetting->internatonalSales){
           $this->defaultState = DB::table('countries')->where('id', $generalSetting->default_state_id)->first();   
           if($this->defaultState)
           {
            $this->getCouriers = Courier::with('getThresholds')->where('status', 1)->get();
            $filteredCouriers = [];   
           
            foreach ($this->getCouriers as $courier) {
                
                foreach (explode(',', $courier->country) as $country) {
              
                    if ($country == $this->defaultState->country_name) {
                  
                        $filteredCouriers[] = $courier;
                     
                        break;
                    }
                }
            }
        
            
            $this->getCouriers = $filteredCouriers;
            $this->billingState = $this->defaultState->country_name;
            $this->shippingState = $this->defaultState->country_name;
            $this->companyState = $this->defaultState->country_name;
           }        
        }else{
            $this->getStates = DB::table('countries')->all();
        }
        session()->put('formatedTotal', $this->formatedTotal);  
       
    }

    public function render()
    {      

        return view('livewire.front.checkout-component')->layout('layouts.front');
    }

   

    public function removeItem($cartKey)
    {
        $cartItems = session()->get('cart.items', []);

       
        if (array_key_exists($cartKey, $cartItems)) {
           
            unset($cartItems[$cartKey]);
            $this->dispatch('updateCartCount', count($cartItems))->to(Dispatcher::class);
            $this->dispatch('updateCartTotal', $this->calculateCartTotal($cartItems))->to(Dispatcher::class);
            $this->dispatch('getCartItems', $cartItems)->to(Dispatcher::class);
          
            session()->put('cart.items', $cartItems);
    
      
            $this->cartItems = $cartItems;
            $total = 0;
            foreach($this->cartItems as $item)
            {
                $total += $item['original_price'] * $item['quantity'];
            }

            $this->getTotal($total);
        }
    
        
    }

    public  function paymentCheck($response)
    {
        
            if($response=='succeeded')
            {
                $this->paymentStatus = 'Completed';
                $this->clearSession();
             
            }else{
                toastr()->error('Payment failed or is pending.');
            }
    }
    public function placeOrder()
    {
      
       $customer = new CompanyCustomer();
       $customer->first_name = session()->has('billingName') ? session()->get('billingName') : '';
         $customer->last_name = session()->has('billingLastName') ? session()->get('billingLastName') : '';
         $customer->email = session()->has('billingEmail') ? session()->get('billingEmail') : '';
            $customer->phone = session()->has('billingPhone') ? session()->get('billingPhone') : '';
         $customer->address = session()->has('billingAddress') ? session()->get('billingAddress') : '';
         $customer->city = session()->has('billingCity') ? session()->get('billingCity') : '';
            $customer->state = session()->has('billingState') ? session()->get('billingState') : '';
            $customer->zip = session()->has('billingZip') ? session()->get('billingZip') : '';
            $customer->province = session()->has('billingProvince') ? session()->get('billingProvince') : '';
            $customer->company_fiscal = session()->has('companyFiscal') ? session()->get('companyFiscal') : '';
            $customer->company_identification = session()->has('companyIdentification') ? session()->get('companyIdentification') : '';
            $customer->company_name = session()->has('companyName') ? session()->get('companyName') : '';
            $customer->company_email = session()->has('companyEmail') ? session()->get('companyEmail') : '';
            $customer->company_phone = session()->has('companyPhone') ? session()->get('companyPhone') : '';
            $customer->company_address = session()->has('companyAddress') ? session()->get('companyAddress') : '';
            $customer->company_city = session()->has('companyCity') ? session()->get('companyCity') : '';
            $customer->company_state = session()->has('companyState') ? session()->get('companyState') : '';
            $customer->company_zip = session()->has('companyZip') ? session()->get('companyZip') : '';
            $customer->company_province = session()->has('companyProvince') ? session()->get('companyProvince') : '';
            $customer->company_contact = session()->has('companyContact') ? session()->get('companyContact') : '';
            $customer->administrator_name = session()->has('administratorName') ? session()->get('administratorName') : '';
            $customer->company_tax_status = session()->has('taxPayment') ? session()->get('taxPayment') : '';
       
       try{
            $customer->save();

            $order = new Order();
            $order->user_id = $customer->id;
            $order->customer_name = $customer->first_name.' '.$customer->last_name;
            $order->customer_email = $customer->email;
            $order->customer_phone = $customer->phone;
            $order->customer_address = $customer->address;
            $order->customer_city = $customer->city;
            $order->customer_country = $customer->state;
            $order->customer_zip = $customer->zip;
            $order->shipping_cost = 0;
            $order->shipping_name = session()->has('receiverName') ? session()->get('receiverName') : '';
            $order->shipping_email = session()->has('shippingEmail') ? session()->get('shippingEmail') : '';
            $order->shipping_phone = session()->has('shippingPhone') ? session()->get('shippingPhone') : '';
            $order->shipping_address = session()->has('shippingAddress') ? session()->get('shippingAddress') : '';
            $order->shipping_city = session()->has('shippingCity') ? session()->get('shippingCity') : '';
            $order->shipping_country = session()->has('shippingState') ? session()->get('shippingState') : '';
            $order->shipping_zip = session()->has('shippingZip') ? session()->get('shippingZip') : '';
            $order->order_note = session()->has('shippingMentions') ? session()->get('shippingMentions') : '';
            $order->shipping = session()->has('shippingMethodName') ? session()->get('shippingMethodName') : '';
            $order->paid_amount = 0;
            $order->order_number  = rand(100000,999999);
            $order->payment_status = $this->paymentStatus;
            $order->totalQty = 1;
            $order->cart = session()->has('cart.items') ? json_encode(session()->get('cart.items')) : [];
            $order->shipping_email = session()->has('shippingEmail') ? session()->get('shippingEmail') : '';
            $order->shipping_phone = session()->has('shippingPhone') ? session()->get('shippingPhone') : '';
            $order->shipping_address = session()->has('shippingAddress') ? session()->get('shippingAddress') : '';
            $order->shipping_city = session()->has('shippingCity') ? session()->get('shippingCity') : '';
            $order->customer_country = session()->has('shippingState') ? session()->get('shippingState') : '';
            $order->shipping_zip = session()->has('shippingZip') ? session()->get('shippingZip') : '';
            $order->pay_amount = session()->has('formatedTotal') ? session()->get('formatedTotal') : 0;
            $order->payment_status = 'Pending';
            $order->status = 'Pending';        
            try{
                if($order->save()){
                    
                    $methodName = session()->has('paymentMethodName') ? session()->get('paymentMethodName') : 'Cache On Delivery';
                    if(!$methodName=='creditCard'){
                        $this->paymentStatus = 'Completed';
                        $this->clearSession();
                    }else{
                        $sendOrder = new StripePaymentController();
                        $sendOrder->catchOrder($order->id);
                    }
                   
                }
            }catch(\Exception $e){
                dd($e->getMessage());
                toastr()->error('An error occurred while saving order information');
                Log::error('An error occurred while saving order information: '.$e->getMessage());
            }
           

       }catch(\Exception $e){
            dd($e->getMessage());
           toastr()->error('An error occurred while saving customer information');
           Log::error('An error occurred while saving customer information: '.$e->getMessage());
       }
        

       
    }

    public function clearSession()
    {
        $adminUser = Auth::guard('admin')->user();
    
        // Preserve the 'web' guard user (if you're using another guard for regular users)
        $webUser = Auth::guard('web')->user();
        
        // Clear all session data
        Session::flush();
        
        // Re-authenticate the users for their respective guards
        if ($adminUser) {
            Auth::guard('admin')->login($adminUser);
        }
    
        if ($webUser) {
            Auth::guard('web')->login($webUser);
        }

        return redirect()->route('front.index');
    }

    public function updateQuantity($cartKey, $newQuantity)
    {
       
        if ($newQuantity <= 0) {
            session()->flash('error', 'Quantity must be greater than 0.');
            return;
        }
    
        $cartItems = session()->get('cart.items', []);
      
    
        if (isset($cartItems[$cartKey])) {
    
          
            $item = $cartItems[$cartKey];
            
          
            $item['quantity'] = $newQuantity;


            $cartItems[$cartKey] = $item;
    
    
            session()->put('cart.items', $cartItems);
    
       
            $this->formatedTotal = $this->calculateCartTotal($cartItems);

            $this->productTotal = $item['original_price'] * $newQuantity;

            session()->put('cart.total', $this->formatedTotal);
    
       
            $this->dispatch('getCartItems', $cartItems)->to(Dispatcher::class);
            $this->dispatch('updateCartCount', count($cartItems))->to(Dispatcher::class);
            $this->dispatch('updateCartTotal', $this->formatedTotal)->to(Dispatcher::class);
    
          
            
    
        } else {
          
            toastr()->error('error', 'Item not found in cart.');
        }
    }
    public function calculateCartTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['original_price'] * $item['quantity'];
            
        }
        return $total;
    }

    public function getTotal($total)
    {
        session()->forget('formatedTotal');
        session()->put('formatedTotal', $total);
        return $this->formatedTotal = $total;

    }

    public function updatedProfilePhoto()
    {
        $this->validate([
            'profilePhoto' => 'image|max:1024|mimes:jpg,png,jpeg,gif,bmp,svg',
        ]);

        if($this->emailAddress){
           $this->dirPath='front/images/users/'.$this->emailAddress.'/';
        }

        $photo = $this->profilePhoto->getClientOriginalName();
        $path = $this->dirPath.$photo;
        if(!File::exists($this->dirPath)){
            File::makeDirectory($this->dirPath, 0777, true, true);
        }
        Image::make($this->profilePhoto)->resize(300, 300)->save($path);
        $this->getProfilePhoto = $photo;
       
    }

    public function loginUser()
    {
        $this->validate([
            'userName' => 'required|string',
            'loginPassword' => 'required|string',
            
        ]);

    
        $credentials = ['password' => $this->loginPassword];

        if (filter_var($this->userName, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $this->userName;
        } else {
            $credentials['phone'] = $this->userName;
        }

        
        if (Auth::guard('web')->attempt($credentials, $this->rememberMe)) {
        
            session()->regenerate();

    
            toastr()->success('User logged in successfully');
            $this->billingAddressOpen=true;
            $this->billingName = Auth::guard('web')->user()->name;
            $this->billingEmail = Auth::guard('web')->user()->email;
            $this->billingPhone = Auth::guard('web')->user()->phone;
            
        }

    }

    public function changePerson($person)
    {
        if($person == 'isCompany'){
            $this->companyFormOpen = true;
            $this->identifyPerson = 'isCompany';
        }else{
            $this->companyFormOpen = false;
            $this->identifyPerson = 'physicalPerson';
        }
    }


    public function registerUser()
    {
        $this->validate([

            'fullName' => 'required',
            'emailAddress' => 'required|email|unique:users,email',
            'phoneNumber' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
           
        ]);

        try{
            $user = new User();
            $user->name = $this->fullName;
            $user->email = $this->emailAddress;
            $user->phone = $this->phoneNumber;
            $user->password = Hash::make($this->password);
            $user->photo = $this->getProfilePhoto;
            $user->save();
            $credentials = ['password' => $this->password, 'email' => $this->emailAddress];
      
            if (Auth::guard('web')->attempt($credentials)) {
                toastr()->success('User registered successfully');
                $this->billingAddressOpen=true;
                $this->billingName = $this->fullName;
                $this->billingEmail = $this->emailAddress;
                $this->billingPhone = $this->phoneNumber;

            }

        }catch(\Exception $e){
           
            toastr()->error('An error occurred while registering user');
            Log::error('An error occurred while registering user: '.$e->getMessage());
        }
    }

    public function nextStep($step)
    {
         $this->$step();
    }
    public function billingAddress()
    {
        if($this->identifyPerson=='physicalPerson'){
            $this->validate([
                'billingName' => 'required',
                'billingLastName' => 'required',
                'billingEmail' => 'required|email',
                'billingPhone' => 'required',
                'billingAddress' => 'required',
                'billingCity' => 'required',
                'billingState' => 'required',
                'billingZip' => 'required',
            ]);
        }if($this->identifyPerson=='isCompany'){
            $this->validate([
                'billingName' => 'required',
                'billingLastName' => 'required',
                'billingEmail' => 'required|email',
                'billingPhone' => 'required',
                'billingAddress' => 'required',
                'billingCity' => 'required',
                'billingState' => 'required',
                'billingZip' => 'required',
                'companyFiscal' => 'required',
                'companyIdentification' => 'required',
                'companyName' => 'required',
                'companyEmail' => 'required|email',
                'companyPhone' => 'required',
                'companyAddress' => 'required',
                'companyCity' => 'required',
                'companyState' => 'required',
                'companyZip' => 'required',
            ]);
        }

       if(!$this->identifyPerson=='isCompany')
       {
        session()->put('billingName', $this->billingName);
        session()->put('billingLastName', $this->billingLastName);
        session()->put('billingEmail', $this->billingEmail);
        session()->put('billingPhone', $this->billingPhone);
        session()->put('billingAddress', $this->billingAddress);
        session()->put('billingCity', $this->billingCity);
        session()->put('billingState', $this->billingState);
        session()->put('billingZip', $this->billingZip);
        session()->put('billingProvince', $this->billingProvince);
        session()->put('companyFiscal', $this->companyFiscal);
        session()->put('personIdenfity', $this->identifyPerson);
        session()->forget('companyIdentification');
        session()->forget('companyName');
        session()->forget('companyEmail');
        session()->forget('companyPhone');
        session()->forget('companyAddress');
        session()->forget('companyCity');
        session()->forget('companyState');
        session()->forget('companyZip');
        session()->forget('companyProvince');
        session()->forget('companyContact');
        session()->forget('administratorName');
        session()->forget('companyFormOpen');
        session()->forget('taxPayment');
        session()->forget('sendInfo');

       }else{
            session()->put('billingName', $this->billingName);
            session()->put('billingLastName', $this->billingLastName);
            session()->put('billingEmail', $this->billingEmail);
            session()->put('billingPhone', $this->billingPhone);
            session()->put('billingAddress', $this->billingAddress);
            session()->put('billingCity', $this->billingCity);
            session()->put('billingState', $this->billingState);
            session()->put('billingZip', $this->billingZip);
            session()->put('billingProvince', $this->billingProvince);
            session()->put('companyFiscal', $this->companyFiscal);
            session()->put('personIdenfity', $this->identifyPerson);
            session()->put('companyIdentification', $this->companyIdentification);
            session()->put('companyName', $this->companyName);
            session()->put('companyEmail', $this->companyEmail);
            session()->put('companyPhone', $this->companyPhone);
            session()->put('companyAddress', $this->companyAddress);
            session()->put('companyCity', $this->companyCity);
            session()->put('companyState', $this->companyState);
            session()->put('companyZip', $this->companyZip);
            session()->put('companyContact', $this->companyContact);
            session()->put('administratorName', $this->administratorName);
            session()->put('companyProvince', $this->companyProvince);
            session()->put('companyFormOpen', $this->companyFormOpen);
            session()->put('taxPayment', $this->taxPayment);   
            session()->put('sendInfo', $this->sendInfo);    
       }
        
        session()->forget('billingAddressOpen');
        session()->put('shippingAddressOpen', true);
        if($this->sendInfo){
            $this->receiverName = $this->companyName;
            $this->shippingEmail = $this->companyEmail;
            $this->shippingPhone = $this->companyPhone;
            $this->shippingAddress = $this->companyAddress;
            $this->shippingCity = $this->companyCity;
            $this->shippingState = $this->companyState;
            $this->shippingZip = $this->companyZip;

        }else{
            $this->receiverName = $this->billingName;
            $this->shippingEmail = $this->billingEmail;
            $this->shippingPhone = $this->billingPhone;
            $this->shippingAddress = $this->billingAddress;
            $this->shippingCity = $this->billingCity;
            $this->shippingState = $this->billingState;
            $this->shippingZip = $this->billingZip;

        }
        $this->billingAddressOpen=false;
        $this->shippingAddressOpen=true;

        session()->put('receiverName', $this->receiverName);
        session()->put('shippingEmail', $this->shippingEmail);
        session()->put('shippingPhone', $this->shippingPhone);
        session()->put('shippingAddress', $this->shippingAddress);
        session()->put('shippingCity', $this->shippingCity);
        session()->put('shippingState', $this->shippingState);
        session()->put('shippingZip', $this->shippingZip);
        session()->put('shippingMentions', $this->shippingMentions);

    }

    public function shippingAddress()
    {
        $this->validate([
            'receiverName' => 'required',
            'shippingEmail' => 'required|email',
            'shippingPhone' => 'required',
            'shippingAddress' => 'required',
            'shippingCity' => 'required',
            'shippingState' => 'required',
            'shippingZip' => 'required',
        ]);

        session()->put('receiverName', $this->receiverName);
        session()->put('receiverFax', $this->receiverFax);
        session()->put('shippingEmail', $this->shippingEmail);
        session()->put('shippingPhone', $this->shippingPhone);
        session()->put('shippingAddress', $this->shippingAddress);
        session()->put('shippingCity', $this->shippingCity);
        session()->put('shippingState', $this->shippingState);
        session()->put('shippingZip', $this->shippingZip);
        session()->forget('shippingAddressOpen');
        session()->put('shippingMentions', $this->shippingMentions);
        session()->put('shippingMethodOpen', true);
       
        $this->shippingAddressOpen=false;
        $this->shippingMethodOpen=true;
       
    }

    public function changeShippingMethod($id)
    {
        $this->shippingMethodName = Shipping::find($id)->title;
        $this->selectedShippingMethodPrice = Shipping::find($id)->price;
        session()->put('shippingMethodPrice', $this->selectedShippingMethodPrice);
        session()->put('shippingMethodName', $this->shippingMethodName);
    }

    public function shippingMethod()
    {
   
        if($this->shippingMethodName=='Courier'){
            $this->validate([
                'shippingMethodName' => 'required',
                'courierId' => 'required',
            ]);           
        }
       else{
            $this->validate([
                'shippingMethodName' => 'required',
            ]);
       }

        session()->put('shippingMethodName', $this->shippingMethodName);
        session()->put('courierId', $this->courierId);
        session()->forget('shippingMethodOpen');
        session()->put('paymentMethodOpen', true);
        $this->shippingMethodOpen=false;
        $this->paymentMethodOpen=true;
    }

    public function paymentMethod()
    {
        $this->validate([
            'paymentMethodName' => 'required',
        ]);

        session()->put('paymentMethodName', $this->paymentMethodName);
        session()->forget('paymentMethodOpen');
        session()->put('orderReviewOpen', true);
        $this->formatedTotal = session()->has('formatedTotal') ? session()->get('formatedTotal') : 0;
        $this->paymentMethodOpen=false;
        $this->orderReviewOpen=true;
    }

    public function changePaymentMethod($method)
    {
  
        session()->forget('paymentMethodName');
        $this->paymentMethodName = $method;
        session()->put('paymentMethodName', $this->paymentMethodName);
    }

    public function regenerateCaptcha()
    {
        return captcha_img();
    }
}
