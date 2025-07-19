<?php

namespace App\Livewire\Front;

use App\Models\Rating;
use App\Models\Product;
use Livewire\Component;
use App\Models\Currency;
use App\Models\Wishlist;
use Illuminate\Support\Str;
use App\Traits\AddToCompare;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Livewire\Front\Components\MiniCart;
use App\Livewire\Front\Components\Dispatcher;

class ProductComponent extends Component
{
    use AddToCompare;
    public $slug;
    public $productDetails;
    public $productQuality;
    public $productPrice;
    public $productValue;
    public $productRatings=[];
    public $nickName;
    public $reviewSummary;
    public $reviewDetails;
    public $productAttributes;
    public $previousTotal;
    public $productQuantity=1;
    public $productSizes;
    public $selectedPrices = [];
    public $productTotal;
    public $additionalPrice = 0;
    public $totalCost;
    public $relatedProducts = [];
    public $productFromCategory = [];
    public $originalTotal;
    public $userId;
   
    public function mount()
    {
        Auth::guard('web')->check() ? $this->userId = Auth::id() : $this->userId = 0;
        $this->slug = request()->slug;
        $this->productDetails = Product::where('slug', $this->slug)->first();
        $this->productRatings = $this->getProductRatings();
        $currency_value = session()->has('current_currency') ? Currency::find(session()->get('current_currency'))->value : Currency::where('is_default', 1)->first()->value;
        $this->productTotal = $this->productDetails->price*$currency_value;
        $this->previousTotal = $this->productDetails->previous_price*$currency_value;
        $this->originalTotal = $this->productDetails->price;
        $this->productFromCategory = Product::where('category_id', $this->productDetails->category_id)->inRandomOrder()->get();
        $this->relatedProducts = Product::where('category_id', $this->productDetails->category_id)->where('subcategory_id',$this->productDetails->subcategory_id)->where('id','!=',$this->productDetails->id)->inRandomOrder()->limit(4)->get();
        

    }
    public function render()
    {
        
        $this->productRatings  = $this->getProductRatings();
        return view('livewire.front.product-component',[
            'productDetails' => $this->productDetails, 
            'productRatings' => $this->productRatings,

        ])->layout('layouts.front');
    }

    public function setOpenProperty($propertyName)
    {
        Session::put('openProperty', $propertyName);
    }

    public function incrementProductPrice($attributeKey, $selectedPrice)
    {
        $currency_value = session()->has('current_currency') ? Currency::find(session()->get('current_currency'))->value : Currency::where('is_default', 1)->first()->value;
           
        
            $this->selectedPrices[$attributeKey] = $selectedPrice;

            
            $this->additionalPrice = array_sum($this->selectedPrices);

           
            
            $totalProduct = $this->productDetails->price + $this->additionalPrice;

            $totalPrevious = $this->productDetails->previous_price + $this->additionalPrice;
            
            $totalOriginal = $this->productDetails->price + $this->additionalPrice;

           
            $this->productTotal = $totalProduct * $currency_value;

            $this->previousTotal = $totalPrevious * $currency_value;

            $this->originalTotal = $totalOriginal;

            

          
    }

    public function incrementQuantity()
    {
        $this->productQuantity++;
        $this->totalCost = $this->productTotal * $this->productQuantity;

    }
    
    public function decrementQuantity()
    {
        if ($this->productQuantity > 1) {
            $this->productQuantity--;
        } else {
            $this->productQuantity = 1;
        }
        $this->totalCost = $this->productTotal * $this->productQuantity;
    }
   
    public function addToCart($productId)
    {
        $productDetails = Product::find($productId);
        

        if(session()->has('current_currency')) {
            $current_currency_id = session()->get('current_currency');
            $current_currency = Currency::find($current_currency_id);
        } else {
            $current_currency = Currency::where('is_default', 1)->first();
            $current_currency_id = $current_currency->id;
        }
    

        $currency_value = $current_currency->value;
    

        $this->productTotal = $productDetails->price * $currency_value;
        $this->previousTotal = $productDetails->previous_price * $currency_value; 
        $this->originalTotal = $productDetails->price;
    

        $this->additionalPrice = array_sum($this->selectedPrices); 
        
   
        $totalProduct = $productDetails->price + $this->additionalPrice;
        $this->productTotal = $totalProduct * $currency_value; 
        $totalPrevious = $productDetails->previous_price + $this->additionalPrice;
        $this->previousTotal = $totalPrevious * $currency_value;
        $totalOriginal = $productDetails->price + $this->additionalPrice;
        $this->originalTotal = $totalOriginal;
        

        $cartKey = $this->generateCartKey($productId, $this->selectedPrices);
    
        $cartItem = [
            'product_id' => $productId,
            'quantity' => $this->productQuantity,
            'cart_key' => $cartKey,
            'user_id' => $this->userId,
            'currency_id' => $current_currency_id,
            'attributes' => $this->selectedPrices,
            'price' => $this->productTotal, 
            'original_price' => $this->originalTotal,
        ];
  
        $cart = session()->get('cart.items', []);
    
        if (isset($cart[$cartKey])) {
        
            if ($cart[$cartKey]['quantity'] == $this->productQuantity) {
                toastr()->info('This product with the selected attributes and quantity is already in the cart. Visit the product to update quantity or attributes. <a href="'.route('view.cart').'" class="text-primary">View Cart</a>');
            } else {
            
                if ($this->productQuantity > $cart[$cartKey]['quantity']) {
                    $cart[$cartKey]['quantity'] = $this->productQuantity;
                    $cart[$cartKey]['price'] = $this->productTotal;
                    $cart[$cartKey]['original_price'] = $this->originalTotal;
                    toastr()->success('Product quantity updated in the cart.');
                } elseif ($this->productQuantity < $cart[$cartKey]['quantity']) {
                    $cart[$cartKey]['quantity'] = $this->productQuantity;
                    $cart[$cartKey]['price'] = $this->productTotal;
                    $cart[$cartKey]['original_price'] = $this->originalTotal;
                    $this->productQuantity = $cart[$cartKey]['quantity'];
                    $cart[$cartKey]['currency_id'] = $current_currency_id;
                    $cart[$cartKey]['user_id'] = $this->userId;
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

    public function submitReview()
    {
        $this->validate([
            'productQuality' => 'required',
            'productPrice' => 'required',
            'productValue' => 'required',
            'nickName' => 'required',
            'reviewSummary' => 'required',
            'reviewDetails' => 'required',
        ]);
        $rating = new Rating();
        try{
            $rating->product_id = $this->productDetails->id;
            $rating->quality = $this->productQuality;
            $rating->price = $this->productPrice;
            $rating->value = $this->productValue;
            $rating->nick_name = $this->nickName;
            $rating->review_summary = $this->reviewSummary;
            $rating->user_id = 1;
            $rating->review_date = now();
            $rating->review = $this->reviewDetails;
            $rating->rating = ($this->productQuality + $this->productPrice + $this->productValue) / 3;
            $rating->save();
            $this->productRatings = $this->getProductRatings();
            $this->productPrice=null;
            $this->productQuality=null;
            $this->productValue=null;
            $this->nickName=null;
            $this->reviewSummary=null;
            $this->reviewDetails=null;
            toastr()->success('Review submitted successfully with rating of '.round($rating->rating,2));   
        }catch(\Exception $e){
            toastr()->error('Something went wrong, please try again');
            Log::error($e->getMessage());
            return;
        }
    }

    public function addToWishlist($productId)
    {
        if(Auth::guard('web')->check()){
             $wishlistCheck = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->first();
            if(!$wishlistCheck){
                $wishlist = new Wishlist();
                $wishlist->user_id = Auth::id();
                $wishlist->product_id = $productId;
                $wishlist->save();
                toastr()->success( 'Product added to wishlist');
            }else{
               toastr()->error('Product already exists in wishlist');
            }
        }else{
            toastr()->error('Please login to add product in wishlist.');
        }
    }

    public function getProductRatings()
    {
        return Rating::where('product_id', $this->productDetails->id)->orderBy('id','desc')->limit(5)->get();
    }

}
