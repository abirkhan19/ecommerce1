<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistComponent extends Component
{
    public $wishList = [];
    public function render()
    {
        $this->wishList = Wishlist::where('user_id', Auth::guard('web')->id())->get();
        return view('livewire.user.wishlist-component',[
            'wishList' => $this->wishList
        ]);
    }

    public function addToWishList($productId)
    {
        $wishlistCheck = Wishlist::where('user_id', Auth::guard('web')->id())->where('product_id', $productId)->first();
        if(!$wishlistCheck){
            $wishlist = new Wishlist();
            $wishlist->user_id = Auth::guard('web')->id();
            $wishlist->product_id = $productId;
            $wishlist->save();
        }else{
            session()->flash('error', 'Product already exists in wishlist');
        }
       
    }
}
