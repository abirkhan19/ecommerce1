<?php 

namespace App\Livewire\Front;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Attribute;
use App\Models\Subcategory;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Childcategory;
use App\Models\Generalsetting;
use App\Models\AttributeOption;
use App\Livewire\Front\Components\Dispatcher;

class LoadShopComponent extends Component
{
    use WithPagination;

    public $type;
    public $quantity;
    public $slug;
    public $shopHolder;
    public $minPrice;
    public $maxPrice;
    public $filterByPrice = []; 
    public $categoryId;
    public $filterByCategoryId = [];
    public $column_id;
    public $pageSize=20;
    public $filterByAttributes = [];
    public $priceRange = [];
    public $setMinLabel;
    public $setMaxLabel;
    public $orderBy = 'price';
    public $orderType = 'asc';
    public $orderOptions;
    

    public function mount($type, $slug)
    {
        $this->type = $type;
        $settings = Generalsetting::find(1);
        $this->pageSize = $settings->product_page_size ?? 20;
        // Set minPrice and maxPrice based on category, subcategory, or childcategory
        if ($type == 'category') {
            $this->shopHolder = Category::where('slug', $slug)->first();           
            $this->column_id = 'category_id';
        }
        if ($type == 'subcategory') {
            $this->shopHolder = Subcategory::where('slug', $slug)->first();           
            $this->column_id = 'subcategory_id';
        }
        if ($type == 'childcategory') {
            $this->shopHolder = Childcategory::where('slug', $slug)->first();
            $this->column_id = 'childcategory_id';
        }

        $getMin = Product::where($this->column_id, $this->shopHolder->id)->orderBy('price', 'asc')->first();
        $getMax = Product::where($this->column_id, $this->shopHolder->id)->orderBy('price', 'desc')->first();
        $getMax ? $this->maxPrice = ceil($getMax->price) : $this->maxPrice = 0;
        $getMin ? $this->minPrice = floor($getMin->price) : $this->minPrice = 0;

       
    }

    #[On('updateSliersPrice')]
    public function updateSliersPrice($min,$max)
    {
        $this->priceRange = [
            'min' => max(0, (int)$min), // Ensure min is not less than 0
            'max' => max(0, (int)$max), // Ensure max is not less than 0
        ];
        $this->setMinLabel = $this->priceRange['min'];
        $this->setMaxLabel = $this->priceRange['max'];
    } 
    
    public function clearAllCompareProducts()
    {
        session()->forget('compare.products');
        toastr()->success('All products removed from compare list.');
    }

    // Render the component with pagination
    public function render()
    {
        $shopItems = $this->getShopBuilder()->paginate($this->pageSize);
        return view('livewire.front.load-shop-component', [
            'shopItems' => $shopItems,
            'priceIntervals' => $this->getPriceIntervals()  // Pass intervals to the view
        ])->layout('layouts.front');
    }

    // Generate price intervals with first, middle, and last price ranges
    public function getPriceIntervals()
    {
        if(Product::where($this->column_id, $this->shopHolder->id)->count() > 4 && $this->maxPrice > $this->minPrice+10) {
        
       
            $range = $this->maxPrice - $this->minPrice;
            $interval = round($range / 4); // Divide the range into 4 intervals and round them
            
            // Create an array of price intervals
            return [
                ['min' => $this->minPrice, 'max' => $this->minPrice + $interval], 
                ['min' => $this->minPrice + $interval, 'max' => $this->minPrice + 2 * $interval], 
                ['min' => $this->minPrice + 2 * $interval, 'max' => $this->minPrice + 3 * $interval], 
                ['min' => $this->minPrice + 3 * $interval, 'max' => $this->maxPrice], 
            ];
        }
        else{
            return [];
        }
    }   

    // Build the product query with optional price filter
    public function updated($propertyName)
    {
        if(str_contains($propertyName, 'filterByPrice')) {
            $this->resetPage();
        }
       
    }
    public function getShopBuilder()
    {
        return Product::where($this->column_id, $this->shopHolder->id)
            // Filter by category ID
            ->when(!empty($this->filterByCategoryId), function ($query) {
                $query->whereIn('category_id', $this->filterByCategoryId);
            })
        
            // Filter by attributes (JSON column)
            ->when(!empty($this->filterByAttributes), function ($query) {
                // Get the selected AttributeOptions (filters)
                $getAttributeOptions = AttributeOption::whereIn('id', $this->filterByAttributes)->get();

                // Create a mapping of attribute IDs to the selected values
                $attributeValues = [];
                foreach ($getAttributeOptions as $option) {
                    $attributeValues[$option->attribute_id][] = $option->name;
                }

                // Get all the unique attribute names related to the selected options
                $attributeIds = $getAttributeOptions->pluck('attribute_id')->unique();
                $attributes = Attribute::whereIn('id', $attributeIds)->get();

                // Map attribute_id to input_name (attribute name)
                $attributeNames = [];
                foreach ($attributes as $attribute) {
                    $attributeNames[$attribute->id] = $attribute->input_name;
                }

                // Apply the filter for each attribute
                foreach ($attributeValues as $attributeId => $values) {
                    // Retrieve the attribute name (input_name) based on the attribute_id
                    if (isset($attributeNames[$attributeId])) {
                        $attributeName = $attributeNames[$attributeId];

                        // Group the values together for 'orWhereJsonContains'
                        $query->where(function($query) use ($attributeName, $values) {
                            foreach ($values as $value) {
                                // Trim whitespace from values (in case there are extra spaces)
                                $value = trim($value);
                                $query->orWhereJsonContains('attributes->' . $attributeName . '->values', $value);
                            }
                        });
                    }
                }
            })
            ->when($this->priceRange, function ($query) {
                $query->whereBetween('price', [$this->priceRange['min'], $this->priceRange['max']]);
            })
            // Filter by price range
            ->when(!empty($this->filterByPrice), function ($query) {
                $query->where(function ($query) {
                    foreach ($this->filterByPrice as $range) {
                        // Parse the range into min and max values
                        list($min, $max) = explode('-', $range);
                        $query->orWhereBetween('price', [(int)$min, (int)$max]);
                    }
                });
            })->orderBy($this->orderBy, $this->orderType);
    }

    
    public function updatedOrderOptions()
    {
        if($this->orderOptions =='productNameAsc')
        {
            $this->orderBy = 'name';
            $this->orderType = 'asc';
        }
        if($this->orderOptions =='productNameDesc')
        {
            $this->orderBy = 'name';
            $this->orderType = 'desc';
        }
        if($this->orderOptions =='priceAsc')
        {
            $this->orderBy = 'price';
            $this->orderType = 'asc';
        }
        if($this->orderOptions =='priceDesc')
        {
            $this->orderBy = 'price';
            $this->orderType = 'desc';
        }
        if($this->orderOptions=='newProducts')
        {
            $this->orderBy = 'created_at';
            $this->orderType = 'desc';
        }
        if($this->orderOptions=='oldProducts')
        {
            $this->orderBy = 'created_at';
            $this->orderType = 'asc';
        }
    }

    public function addToCart($productId)
    {
        // Retrieve the product details
        $productDetails = Product::find($productId);
        
        // Retrieve the current currency or default currency
        if (session()->has('current_currency')) {
            $current_currency_id = session()->get('current_currency');
            $current_currency = Currency::find($current_currency_id);
        } else {
            $current_currency = Currency::where('is_default', 1)->first();
            $current_currency_id = $current_currency->id;
        }
    
        // Get the price in the selected currency
        $currency_value = $current_currency->value;
    
        // Determine the product price (use sale price if available, else use regular price)
        $productTotal = $productDetails->price * $currency_value;
        $previousTotal = $productDetails->previous_price * $currency_value; 
        $originalTotal = $productDetails->price;
    
        // Since no additional prices, we can just use the base product price
        $productTotal = $productDetails->price * $currency_value;
        $previousTotal = $productDetails->previous_price * $currency_value;
    
        // Generate cart key based on productId (no need for selected attributes)
        $cartKey = $this->generateCartKey($productId);
    
        // Prepare the cart item with quantity set to 1
        $cartItem = [
            'product_id' => $productId,
            'quantity' => 1, // Always 1 item in cart
            'cart_key' => $cartKey,
            'user_id' => auth()->id(), // Assuming user is logged in, otherwise use a different method to get user id
            'currency_id' => $current_currency_id,
            'price' => $productTotal, // Sale price if exists or regular price
            'original_price' => $originalTotal,
        ];
    
        // Get the existing cart from session
        $cart = session()->get('cart.items', []);
    
        // Check if the product is already in the cart
        if (isset($cart[$cartKey])) {
            toastr()->info('This product is already in the cart. Visit the product to update quantity or attributes. <a href="'.route('view.cart').'" class="text-primary">View Cart</a>');
        } else {
            // Add the product to the cart
            $cart[$cartKey] = $cartItem;
            toastr()->success('Product added to cart.');
        }
    
        // Save the updated cart to the session
        session()->put('cart.items', $cart);
    
        // Dispatch the update cart count and total
        $this->dispatch('updateCartCount', count($cart))->to(Dispatcher::class);
    
        // Calculate the total price of the cart
        $totalPrice = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    
        // Dispatch the updated cart total
        $this->dispatch('updateCartTotal', $totalPrice)->to(Dispatcher::class);
    
        // Dispatch the updated cart items
        $this->dispatch('getCartItems', session()->get('cart.items', []))->to(Dispatcher::class);
    }
// Add this method in your LoadShopComponent class
public function generateCartKey($productId)
{
    // You can create a unique key by simply using the product ID
    // If you had attributes or other factors, you could combine them to create a more unique key
    return 'product_' . $productId;
}    

    

    
    public function updatedPageSize()
    {
        $this->resetPage();
        
    }   
}
