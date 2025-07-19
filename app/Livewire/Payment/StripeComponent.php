<?php

namespace App\Livewire\Payment;

use Livewire\Component;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class StripeComponent extends Component
{
    public $stripe;
    public function mount()
    {
        
        $this->stripe = Stripe::make(config('services.stripe.secret'));
    }
    public function processPayment()
    {
        dd('aici');
        try {
            $charge = $this->stripe->charges()->create([
                'amount' => 2,
                'currency' => 'ron',
                'source' => 'tok_visa',
                'description' => 'Real Payment',
            ]);
            if ($charge['status'] == 'succeeded') {
                session()->flash('success', 'Payment successful!');
            } else {
                session()->flash('error', 'Payment failed or is pending.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Payment failed: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.payment.stripe-component')->layouts('layouts.front');
    }
}
