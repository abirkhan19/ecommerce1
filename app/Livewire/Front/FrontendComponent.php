<?php

namespace App\Livewire\Front;

use App\Models\Blog;
use App\Models\Slider;
use App\Models\Partner;
use App\Models\Product;
use Livewire\Component;
use App\Models\Currency;
use App\Traits\AddToCompare;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Front\Components\MiniCart;
use App\Livewire\Front\Components\Dispatcher;

class FrontendComponent extends Component
{
    use AddToCompare;
    public $productQuantity=1;
    public $selectedPrices = [];
    public $productTotal;
    public $previousTotal;
    public $originalTotal;
    
    public function render()
    {
       
        $sliders = Slider::all();
        $services = DB::table('services')->where('user_id','=',0)->get();
        $bottom_small_banners = DB::table('banners')->where('type','=','BottomSmall')->get();
        $large_banners = DB::table('banners')->where('type','=','Large')->inRandomOrder()->first();
        $top_small_banners = DB::table('banners')->where('type','=','TopSmall')->inRandomOrder()->first();
        $reviews =  DB::table('reviews')->get();
        $best_products = Product::with('user')->where('best','=',1)->where('status','=',1)->get();
        $ps = DB::table('pagesettings')->find(1);            
        $selectable = ['id','user_id','name','slug','features','colors','thumbnail','price','previous_price','attributes','size','size_price','discount_date'];
        $discounted_products =  Product::with('user')->where('is_discount','=',1)->where('status','=',1)->orderBy('id','desc')->get();
        $blog_posts = Blog::where('status','=',1)->orderBy('id','desc')->get();
        return view('livewire.front.frontend-component',[
            'sliders' => $sliders,
            'ps' => $ps,
            'services' => $services,
            'bottom_small_banners' => $bottom_small_banners,
            'top_small_banners' => $top_small_banners,
            'large_banners' => $large_banners,
            'reviews' => $reviews,
            'selectable'=>$selectable,
            'discounted_products' => $discounted_products,
            'best_products' => $best_products,
            'blog_posts' => $blog_posts,
        ])->layout('layouts.front');
    }

    public function addToCart($productId)
    {
        $productDetails = Product::find($productId);
    
      
        if(session()->has('current_currency')){
            $current_currency = DB::table('currencies')->where('id', session()->get('current_currency'))->first();
        } else {
            $current_currency = DB::table('currencies')->where('is_default', '=', 1)->first();
        }
    
     
        $currencyRate = $current_currency->value;
    
       
        $this->productTotal = $productDetails->price * $currencyRate;
        $this->originalTotal = $productDetails->price;
    
       
        $formattedPrice = number_format($this->productTotal, 2, '.', ',');
        $formattedOriginalPrice = number_format($this->originalTotal, 2, '.', ',');
    

        $cartKey = $this->generateCartKey($productId, $this->selectedPrices);
    
     
        if(session()->has('current_currency')){
            $current_currency_id = session()->get('current_currency');
        } else {
            $current_currency_id = Currency::where('is_default', '=', 1)->first()->id;
        }
    
     
        $cartItem = [
            'product_id' => $productId,
            'quantity' => $this->productQuantity,
            'cart_key' => $cartKey,
            'currency_id' => $current_currency_id,
            'user_id' => Auth::guard('web')->check() ? Auth::guard('web')->user()->id : 0,
            'attributes' => $this->selectedPrices,
            'original_price' => $formattedOriginalPrice,
            'price' => $formattedPrice,
        ];
    
        $cart = session()->get('cart.items', []);
    
        if (isset($cart[$cartKey])) {
            
            if ($cart[$cartKey]['quantity'] == $this->productQuantity) {
                toastr()->info('This product with the selected attributes and quantity is already in the cart. Visit the product to update quantity or attributes. <a href="'.route('view.cart').'" class="text-primary">View Cart</a>');
            } else {
                if ($this->productQuantity > $cart[$cartKey]['quantity']) {
                    $cart[$cartKey]['quantity'] = $this->productQuantity;
                    $cart[$cartKey]['price'] = $formattedPrice;
                    toastr()->success('Product quantity updated in the cart.');
                } elseif ($this->productQuantity < $cart[$cartKey]['quantity']) {
                    $cart[$cartKey]['quantity'] = $this->productQuantity;
                    $cart[$cartKey]['price'] = $formattedPrice;
                    $cart[$cartKey]['original_price'] = $formattedOriginalPrice;
                    $cart[$cartKey]['currency_id'] = $current_currency_id;
                    $cart[$cartKey]['user_id'] = Auth::guard('web')->check() ? Auth::guard('web')->user()->id : 0;
                    $this->productQuantity = $cart[$cartKey]['quantity'];
                    toastr()->success('Product quantity downgraded in the cart.');
                }
            }
        } else {
           
            $cart[$cartKey] = $cartItem;
            toastr()->success('Product added to cart.');
        }
    
   
        session()->put('cart.items', $cart);
    
       
        $this->dispatch('updateCartCount', count($cart))->to(Dispatcher::class);
    
      
        $totalPrice = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    
  
        $this->dispatch('updateCartTotal', $totalPrice)->to(Dispatcher::class);
    

        $this->dispatch('getCartItems', session()->get('cart.items', []))->to(Dispatcher::class);
    }
    

    private function generateCartKey($productId, $attributes)
    {
        return $productId . '-' . md5(json_encode($attributes));
    }



}
