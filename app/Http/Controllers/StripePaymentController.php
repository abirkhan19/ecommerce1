<?php

namespace App\Http\Controllers;

use Exception;
use Stripe\Charge;
use Stripe\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Generalsetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Livewire\Front\CheckoutComponent;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class StripePaymentController extends Controller
{
    public $stripe;
    public $orderId;
    public function __construct()
    {
        
        $this->stripe = Stripe::make(config('services.stripe.secret')); 
    }

    public function stripe()
    {
        return view('charge');
    }

    public function getAmount()
    {
       return  session()->has('formatedTotal') ? session()->get('formatedTotal') : 0;
    }
    public function catchOrder($orderId)
    {
        session(['orderId' => $orderId]);
    }
    public function getOrderId()
    {
        return session()->has('orderId') ? session('orderId') : null;
    }
    public function stripePost(Request $request)
    {
        $responseReceiver = new CheckoutComponent();
        $responseReceiver->placeOrder();
        $orderId = session('orderId');        
        $amount = $this->getAmount();
        $orderId = $this->getOrderId();

     
        if($orderId)
        {
            
            try {
        
             
                $amountForPayment = (float) $amount;
    
                $charge = $this->stripe->charges()->create([
                    'amount' => $amountForPayment, 
                    'currency' => 'ron',
                    'source' => $request->stripeToken,
                    'description' => 'Payment From E-commerce',
                ]);
         
           
                if ($charge['status'] == 'succeeded') {
                  
                    
                    Order::find($orderId)->update(['payment_status' => 'Completed','paid_amount' => $amountForPayment]);
                    $responseReceiver->paymentCheck($charge['status']);            
                    session()->forget('orderId');
                    session()->forget('formatedTotal');
                    session()->flash('success', 'Payment successful!');
                    return redirect()->route('front.index');
                    
    
                } else {
                    session()->flash('error', 'Payment failed: ' . $charge['failure_message']);
              
                    $sendTo = $responseReceiver->paymentCheck($status = 'failed');
                    return back();
                }
        
               
             
        
            } catch (\Exception $e) {
                Order::find($orderId)->delete();
                session()->flash('error', 'Payment failed: ' . $e->getMessage());
                return back();
            }
        }else{

            session()->flash('error', 'Order was not placed');
            return back();
        }
        
    }
        
}
