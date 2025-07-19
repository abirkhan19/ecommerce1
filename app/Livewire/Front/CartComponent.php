<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Currency;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Livewire\Front\Components\MiniCart;
use App\Livewire\Front\Components\Dispatcher;

class CartComponent extends Component
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

      
        $currentCurrency = Currency::find($currency_id);

       
        $defaultCurrency = Currency::where('is_default', 1)->first();
        if (!$currentCurrency || !$defaultCurrency) {
          
            return;
        }

        $currentRate = $currentCurrency->value;
        $defaultRate = $defaultCurrency->value;

     
        foreach ($this->cartItems as $key => $item) {
           
            if ($item['currency_id'] != $currency_id) {
                $this->cartItems[$key]['price'] = $item['original_price'] * $currentRate;
                $this->cartItems[$key]['currency_id'] = $currency_id;  
      
            }
        }

      
        Session::put('cart.items', $this->cartItems);

        
        $this->updateCartCount(count($this->cartItems));
        $this->updateCartTotal($this->calculateCartTotal($this->cartItems));
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
    
       
            $this->cartTotal = $this->calculateCartTotal($cartItems);
            session()->put('cart.total', $this->cartTotal);
    
       
            $this->dispatch('getCartItems', $cartItems)->to(Dispatcher::class);
            $this->dispatch('updateCartCount', count($cartItems))->to(Dispatcher::class);
            $this->dispatch('updateCartTotal', $this->cartTotal)->to(Dispatcher::class);
    
          
            
    
        } else {
          
            toastr()->error('error', 'Item not found in cart.');
        }
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

                // Flash success message
                toastr()->success('success', 'Item removed from cart.');
            } else {
                
                toastr()->error('error', 'Item not found in cart.');
        }
    }

    public function clearShoppingCart()
    {
        Session::has('cart.items') ? Session::forget('cart.items') : null;
        Session::has('cart.count') ? Session::forget('cart.count') : null;
        Session::has('cart.total') ? Session::forget('cart.total') : null;
        $this->dispatch('getCartItems', [])->to(Dispatcher::class);
        $this->dispatch('updateCartCount', 0)->to(Dispatcher::class);
        $this->dispatch('updateCartTotal', 0.00)->to(Dispatcher::class);
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
      
        return view('livewire.front.cart-component', [
            'cartItems' => $this->cartItems,
            'cartCount' => $this->cartCount,
            'cartTotal' => $this->cartTotal,
        ])->layout('layouts.front');
    }
}
