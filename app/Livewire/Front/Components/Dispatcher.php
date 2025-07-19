<?php

namespace App\Livewire\Front\Components;


use Livewire\Component;
use App\Livewire\Front\CartComponent;
use App\Livewire\Front\CheckoutComponent;
class Dispatcher extends Component
{
    protected $listeners = [
        'updateCartCount' => 'updateCartCount',
        'updateCartTotal' => 'updateCartTotal',
        'getCartItems' => 'getCartItems',
    ];
    public function render()
    {
        return view('livewire.front.components.dispatcher');
    }

    public function getCartItems($items)
    {
        $this->dispatch('getCartItems',$items)->to(MiniCart::class);
        $this->dispatch('getCartItems',$items)->to(CartComponent::class);
        $this->dispatch('getCartItems',$items)->to(CheckoutComponent::class);
    }

    public function updateCartTotal($total)
    {
        $this->dispatch('updateCartTotal', $total)->to(CartComponent::class);
        $this->dispatch('updateCartTotal', $total)->to(MiniCart::class);
        $this->dispatch('updateCartTotal', $total)->to(CheckoutComponent::class);
    }

    public function updateCartCount()
    {
        session()->has('cart.items') ? $count = count(session('cart.items')) : $count = 0;
        $this->dispatch('updateCartCount', $count)->to(CartComponent::class);
        $this->dispatch('updateCartCount', $count)->to(MiniCart::class);
        $this->dispatch('updateCartCount', $count)->to(CheckoutComponent::class);
    }
}
