<?php

namespace App\Livewire\Front\Components;

use Livewire\Component;
use App\Models\Currency;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Livewire\Front\Components\Dispatcher;

class MiniCart extends Component
{
    protected $listeners = [
        'updateCartCount' => 'updateCartCount',
        'updateCartTotal' => 'updateCartTotal',
        'getCartItems' => 'getCartItems',
    ];
    
    public $cartItems = [];
    public $cartCount = 0;
    public $cartTotal = 0.00;

    public function mount()
    {
  
        $currency_id = Session::get('current_currency', Currency::where('is_default', 1)->first()->id);
        $this->cartCount = Session::get('cart.count', 0);
        $this->cartTotal = Session::get('cart.total', 0.00);
        $this->cartItems = Session::get('cart.items', []);
        if (!empty($this->cartItems)) {
            $this->updateCartPrices($currency_id);
        }
    }

   
    private function updateCartPrices($currency_id)
    {
   
        if (empty($this->cartItems)) {
            return;
        }
       
        foreach ($this->cartItems as $key => $item) {
         
            if ($item['currency_id'] != $currency_id) {
                $this->cartItems[$key]['price'] = $this->convertCurrency($item['original_price'], $item['currency_id'], $currency_id);
                $this->cartItems[$key]['currency_id'] = $currency_id; 
            }
        }
        Session::put('cart.items', $this->cartItems);
        $this->updateCartCount(count($this->cartItems));
        $this->updateCartTotal($this->calculateCartTotal($this->cartItems));
    }


    private function convertCurrency($price, $fromCurrencyId, $toCurrencyId)
    {        
        $fromCurrency = Currency::find($fromCurrencyId);
        $toCurrency = Currency::find($toCurrencyId);
        if (!$fromCurrency || !$toCurrency) {
            return $price;  
        }
        $fromRate = $fromCurrency->value;
        $toRate = $toCurrency->value;

        if ($fromRate == 0 || $toRate == 0) {
            return $price; 
        }

    
        $convertedPrice = $price * $toRate; 
        
        
        return round($convertedPrice, 2);
    }

   
    public function updateCartCount($count)
    {
        Session::put('cart.count', $count);
        $this->cartCount = $count;
    }

 
    public function updateCartTotal($totalPrice)
    {
        Session::put('cart.total', $totalPrice);
        $this->cartTotal = $totalPrice;
    }

    public function getCartItems($items)
    {
        $this->cartItems = $items;
    }

 
    public function removeCartItem($cartKey)
    {
       
        $cartItems = session()->get('cart.items', []);
        
       
        if (isset($cartItems[$cartKey])) {
         
            unset($cartItems[$cartKey]);
            session()->put('cart.items', $cartItems);
            $this->cartTotal = $this->calculateCartTotal($cartItems);
            session()->put('cart.total', $this->cartTotal);       
            $this->dispatch('getCartItems', $cartItems)->to(Dispatcher::class);
            $this->dispatch('updateCartCount', count($cartItems))->to(Dispatcher::class);
            $this->dispatch('updateCartTotal', $this->cartTotal)->to(Dispatcher::class);
            toastr()->success('success', 'Item removed from cart.');
        } else {
            
            toastr()->error('error', 'Item not found in cart.');
        }
    }
   
    private function calculateCartTotal($cartItems)
    {
        $total = 0.00;
        foreach ($cartItems as $item) {
           
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    public function render()
    {
        return view('livewire.front.components.mini-cart', [
            'cartItems' => $this->cartItems,
            'cartCount' => $this->cartCount,
            'cartTotal' => $this->cartTotal,
        ]);
    }
}
