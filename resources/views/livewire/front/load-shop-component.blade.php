<div>
            
  
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a title="Go to Home Page" href="index.html">Home</a><span>&raquo;</span></li>
            <li class=""> <a title="Go to Home Page" href="shop_grid.html">Living Rooms</a><span>&raquo;</span></li>
            <li><strong>Sofas & Couches</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumbs End --> 
  <!-- Main Container -->
  <div class="main-container col2-right-layout">
    <div class="container">
      <div class="row">
        <aside class="right sidebar col-sm-3 col-xs-12">
            <div class="block category-sidebar">
              <div class="sidebar-title">
                <h3>Categories</h3>
              </div>
              <ul class="product-categories">
                <li class="cat-item current-cat cat-parent"><a href= "shop_grid.html">Women</a>
                  <ul class="children">
                    <li class="cat-item cat-parent"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Accessories</a>
                      <ul class="children">
                        <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Dresses</a></li>
                        <li class="cat-item cat-parent"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Handbags</a>
                          <ul style="display: none;" class="children">
                            <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Beaded Handbags</a></li>
                            <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Sling bag</a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li class="cat-item cat-parent"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Handbags</a>
                      <ul class="children">
                        <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; backpack</a></li>
                        <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Beaded Handbags</a></li>
                        <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Fabric Handbags</a></li>
                        <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Sling bag</a></li>
                      </ul>
                    </li>
                    <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Jewellery</a> </li>
                    <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Swimwear</a> </li>
                  </ul>
                </li>
                <li class="cat-item cat-parent"><a href="shop_grid.html">Men</a>
                  <ul class="children">
                    <li class="cat-item cat-parent"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Dresses</a>
                      <ul class="children">
                        <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Casual</a></li>
                        <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Designer</a></li>
                        <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Evening</a></li>
                        <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Hoodies</a></li>
                      </ul>
                    </li>
                    <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Jackets</a> </li>
                    <li class="cat-item"><a href="shop_grid.html"><i class="fa fa-angle-right"></i>&nbsp; Shoes</a> </li>
                  </ul>
                </li>
                <li class="cat-item"><a href="shop_grid.html">Electronics</a></li>
                <li class="cat-item"><a href="shop_grid.html">Furniture</a></li>
                <li class="cat-item"><a href="shop_grid.html">KItchen</a></li>
              </ul>
            </div>
            <div class="block shop-by-side">
              <div class="sidebar-bar-title">
                <h3>Find Your Proudcts</h3>
              </div>
              <div class="block-content">
                <p class="block-subtitle">Shopping Options</p>
               
                <div class="manufacturer-area">
                  <h2 class="saider-bar-title">Categorii</h2>
                  <div class="saide-bar-menu">
                    <ul>
                    @foreach($categories as $category)
                      <li><a href="{{ route('explore.shop',['type'=>'category','slug'=>$category->slug]) }}"><i class="fa fa-angle-right"></i> {{ $category->name }}</a></li>
                    @endforeach
                  
                    </ul>
                  </div>
                </div>
               
            @if(!empty($shopHolder->attributes))
            @foreach($shopHolder->attributes->where('is_filterable',1) as $attribute)
    
                <div class="size-area">
                  <h2 class="saider-bar-title">{{ $attribute->name }}</h2>
                  <div class="size">
                    <ul>
                    @foreach($attribute->attribute_options as $option)
                  
                      <li><a href="javascript:;">
                        <label for="option{{ $option->id }}">
                            <input type="checkbox" id="option{{ $option->id }}" wire:model.live="filterByAttributes" value="{{ $option->id }}" />
                            {{ $option->name }} {{ $attribute->measure_unity ? $attribute->measure_unity : '' }}
                        </label>    
                    </a></li>
                    
                    @endforeach
                    
                    </ul>
                  </div>
                </div>
            
            @endforeach
                @endif 

              </div>
            </div>

          @if(!empty($priceIntervals))
            <div class="block product-price-range ">
              <div class="sidebar-bar-title">
                <h3>Price</h3>
              </div>
              <div class="block-content">
                <div class="slider-range" >
                    <div id="amount-range-price" wire:ignore data-label-reasult="Range:" data-min="0"
                     data-max="{{ floor($maxPrice*$current_currency->value) }}" 
                     data-unit="{{ $current_currency->sign ? $current_currency->sign : $current_currency->name }}" 
                     class="slider-range-price" data-value-min="0" data-value-max="{{ floor($maxPrice/2)*$current_currency->value }}"
                     data-value-min-converted="{{ $minPrice }}" data-value-max-converted="{{ $maxPrice }}"></div> 
                    <div  class="amount-range-price">Range: {{ $current_currency->sign ? $current_currency->sign : $current_currency->name }} {{ $setMinLabel > 0 ? floor($setMinLabel*$current_currency->value) : 0 }} - {{ $current_currency->sign ? $current_currency->sign : $current_currency->name }} {{ $setMaxLabel ? floor($setMaxLabel*$current_currency->value) : floor($maxPrice*$current_currency->value) }}</div>
            
                  <ul class="check-box-list">
                    @foreach($priceIntervals as $interval)
                <li>
                    <!-- Multiple checkboxes for selecting price ranges -->
                    <input type="checkbox" id="p{{ $loop->index }}" 
                           value="{{ $interval['min'] }}-{{ $interval['max'] }}" 
                           wire:model.live="filterByPrice" />
                    <label for="p{{ $loop->index }}">
                        <span class="button"></span>
                        ${{ ceil($interval['min']*$current_currency->value) }} - ${{ ceil($interval['max']*$current_currency->value)  }}
                    </label>
                </li>
                @endforeach
                  </ul>
                </div>
              </div>
            </div>
            @endif 
            @if(session()->has('cart.items'))
            <div class="block sidebar-cart" >
              <div class="sidebar-bar-title">
                <h3>My Cart</h3>
              </div>
              <div class="block-content">
                <p class="amount">There are <a href="shopping_cart.html">{{ count(session()->get('cart.items')) }} items</a> in your cart.</p>
                <ul>
          
                @foreach(session()->get('cart.items') as $cartItem)
                  <li class="item"> <a href="shopping_cart.html" title="Sample Product" class="product-image"><img src="{{ asset('assets/images/products/'.\App\Models\Product::find($cartItem['product_id'])->photo) }}" alt="Sample Product "></a>
                    <div class="product-details">
                      <div class="access"> <a href="shop_grid_right_sidebar.html#" title="Remove This Item" class="remove-cart"><i class="icon-close"></i></a></div>
                      <p class="product-name"> <a href="{{ route('product.details',\App\Models\Product::find($cartItem['product_id'])->slug) }}">
                        {{ \App\Models\Product::find($cartItem['product_id'])->name }}
                      </a> </p>
                      <strong>{{ $cartItem['quantity'] }}</strong> x <span class="price">
                        {{ \App\Models\Product::find($cartItem['product_id'])->price ? round(\App\Models\Product::find($cartItem['product_id'])->price * $current_currency->value, 2) : '0.00' }}
                    </span> </div>
                  </li>
                @endforeach
                 
                </ul>
                <div class="summary">
                  <p class="subtotal"> <span class="label">Cart Subtotal:</span> <span class="price">
                    {{ '0.00' }}
                 </span> </p>
                </div>
                <a href="{{ route('view.cart') }}" class="cart-checkout">
                  <button class="button button-checkout" title="Submit" type="submit"><i class="fa fa-eye"></i> <span>View Cart</span></button>
                </a>
              </div>
            </div>
            @endif  
            @if(session()->has('compare.products'))
            <div class="block compare">
              <div class="sidebar-bar-title">
                <h3>Compare Products ({{ count(session()->get('compare.products'))}})</h3>
              </div>
              <div class="block-content">
                <ol id="compare-items">
                @foreach(session()->get('compare.products') as $compareList)
             
                  <li class="item">
                     <a href="javascript:;" title="{{ $compareList->name }}" class="remove-cart"><i class="icon-close"></i></a>
                    <a href="{{ route('product.details',$compareList->slug) }}" target="_blank" class="product-name"><i class="fa fa-angle-right"></i>{{ $compareList->name }}</a> 
                </li>
                 
                @endforeach
                </ol>
                <div class="ajax-checkout">
                  <button type="submit" title="Submit" class="button button-compare"> <span><i class="fa fa-signal"></i> Compare</span></button>
                  <button type="submit" title="Submit" class="button button-clear" wire:click="clearAllCompareProducts"> <span><i class="fa fa-eraser"></i> Clear All</span></button>
                </div>
              </div>
            </div>
            @endif
         
           
          </aside>
        <div class="col-main col-sm-9 col-xs-12">
          <div class="category-description std">
            <div class="slider-items-products">
              <div id="category-desc-slider" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col1 owl-carousel owl-theme"> 
                  
                  <!-- Item -->
                  <div class="item"> <a href="shop_grid_right_sidebar.html#x"><img alt="" src="images/cat-slider-img1.jpg"></a>
                    <div class="inner-info">
                      <div class="cat-img-title"> <span>Up To 20% Off Decor</span>
                        <h2 class="cat-heading"><strong>Vintage Casual</strong></h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                        <a class="info" href="shop_grid_right_sidebar.html#">Shop Now</a> </div>
                    </div>
                  </div>
                  <!-- End Item --> 
                  
                  <!-- Item -->
                  <div class="item"> <a href="shop_grid_right_sidebar.html#x"><img alt="" src="images/cat-slider-img2.jpg"></a> </div>
                  
                  <!-- End Item --> 
                  
                </div>
              </div>
            </div>
          </div>
          <div class="shop-inner">
            <div class="page-title">
              <h2>Apple</h2>
            </div>
            <div class="toolbar">
              <div class="view-mode">
                <ul>
                  <li class="active"> <a href="shop_grid.html"> <i class="fa fa-th"></i> </a> </li>
                  <li> <a href="shop_list.html"> <i class="fa fa-th-list"></i> </a> </li>
                </ul>
              </div>
              <div class="sorter">
                <div class="short-by">
                  <label>Sort By:</label>
                  <select wire:model.live="orderOptions">
                    <option selected>Options</option>
                    <option value="productNameAsc">Name Asc</option>
                    <option value="productNameDesc">Name Desc</option>
                    <option value="priceAsc">Price Asc</option>
                    <option value="priceDesc">Price Desc</option>
                    <option value="newProduct">Recently Added</option>
                    <option value="oldProduct"></option>
                  </select>
                </div>
                <div class="short-by page">
                  <label>Show:</label>
                  <select wire:model.live="pageSize">
                    <option value="{{ $pageSize }}" {{ $pageSize=='20' ? 'selected' : '' }}>{{ $pageSize=='20' ? $pageSize : '20' }}</option>
                    <option value="40" {{ $pageSize=='40' ? 'selected' : '' }}>{{ $pageSize=='40' ? $pageSize : '40'}}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="product-grid-area">
              <ul class="products-grid">
            @foreach($shopItems as $productItem)
                <li class="item col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
                  <div class="product-item">
                    <div class="item-inner">
                      <div class="product-thumb has-hover-img">
                    @if($productItem->emptyStock())
                        <div class="icon-sale-label sale-left" style="background:gray;">Out Of The Stock</div>
                    @else       
                       @if($productItem->label1)
                        <div class="icon-sale-label sale-left">{{ $productItem->label1 }}</div>
                       @endif  
                       @if($productItem->label2)
                        <div class="icon-new-label new-right">{{ $productItem->label2 }}</div>
                       @endif 
                    @endif
                        
                        <figure> <a href="{{ route('product.details',$productItem->slug) }}">
                            <img src="{{ asset('assets/images/products/'.$productItem->photo) }}" alt="">
                        </a> <a class="hover-img" href="{{ route('product.details',$productItem->slug) }}">
                            <img src="{{ asset('assets/images/products/'.$productItem->photo) }}" alt=""></a></figure>
                        <div class="pr-info-area animated animate2"><a href="{{ route('product.details',$productItem->slug) }}" class="quick-view"><i class="fa fa-search"><span>Quick view</span></i></a> <a href="wishlist.html" class="wishlist"><i class="fa fa-heart"><span>Wishlist</span></i></a> <a href="compare.html" class="compare"><i class="fa fa-exchange"><span>Compare</span></i></a> </div>
                      </div>
                      <div class="item-info">
                        <div class="info-inner">
                          <div class="item-title"> <h4><a title="Ipsums Dolors Untra {{ $productItem->id }}" href="{{ route('product.details',$productItem->slug) }}">Ipsums Dolors Untra </a></h4> </div>
                          <div class="item-content">
                            <div class="rating"> 
                              <i class="fa fa-star"></i> 
                              <i class="fa fa-star"></i> 
                              <i class="fa fa-star-o"></i> 
                              <i class="fa fa-star-o"></i> 
                              <i class="fa fa-star-o"></i> 
                            </div>
                            <div class="item-price">
                              <div class="price-box"> <span class="regular-price"> <span class="price">
                                @php
                                $formattedTotal = $productItem->price ? round($productItem->price * $current_currency->value, 2) : '0.00';
                                $currencySymbol = $current_currency->sign ?? $current_currency->name; // Choose sign or name
                                @endphp
                        
                                @if($gs->currency_format)
                            
                                    @if($current_currency->sign)
                                      
                                        {{ round($formattedTotal,2) }} {{ $current_currency->sign }}
                                    @else
                                  
                                        {{ round($formattedTotal,2) }} {{ $current_currency->name }}
                                    @endif
                                @else
                        
                                    @if($current_currency->sign)
                                    
                                        {{ $current_currency->sign }} {{ $formattedTotal }}
                                    @else
                                        
                                        {{ round($formattedTotal,2) }} {{ $current_currency->name }} 
                                    @endif
                                @endif
                                </span> </span> </div>
                            </div>
                            <div class="pro-action">
                            @if(empty($productItem->attributes))
                              <button type="button" class="add-to-cart-mt" wire:click="addToCart('{{ $productItem->id }}')">  <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
                            @else 
                            <a href="{{ route('product.details',$productItem->slug) }}"> 
                            <button type="button" class="add-to-cart-mt"> <i class="fa fa-shopping-cart"></i><span> View Product</span> </button>
                            </a>
                            @endif 
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
            @endforeach
   
              </ul>
            </div>
            {{ $shopItems->links() }}
          </div>
        </div>
       
      </div>
    </div>
  </div>
  <!-- Main Container End --> 
  
  <!-- service section -->
  
  <div class="jtv-service-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-sm-4 col-xs-12">
          <div class="jtv-service">
            <div class="ser-icon"> <i class="fa fa-truck flip-horizontal"></i> </div>
            <div class="service-content">
              <h5>FREE SHIPPING WORLDWIDE </h5>
              <p>free ship-on oder over $299.00</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-12">
          <div class="jtv-service">
            <div class="ser-icon"> <i class="fa fa-mail-forward"></i> </div>
            <div class="service-content">
              <h5>MONEY BACK GUARATEE! </h5>
              <p>30 days money back guarantee!</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-12">
          <div class="jtv-service">
            <div class="ser-icon"> <i class="fa fa-comments flip-horizontal"></i> </div>
            <div class="service-content">
              <h5>24/7 CUSTOMER SERVICE </h5>
              <p>We support online 24 hours a day</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Hidden inputs for min and max values -->
<input type="hidden" id="input-min" name="min_price" />
<input type="hidden" id="input-max" name="max_price" />
<livewire:front.components.dispatcher /> 
<!-- Display the selected range -->
<div id="slider-value"></div>
</div>
@push('js')
<script src="https://cdn.jsdelivr.net/npm/nouislider@15.6.0/dist/nouislider.min.js"></script>
<script>
    // Wait for the document to load
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.getElementById('amount-range-price');

        // Get min and max values from data attributes
        const min = parseInt(slider.getAttribute('data-value-min-converted'));
        const max = parseInt(slider.getAttribute('data-value-max-converted'));

        // Calculate the midpoint value
        const midpoint = Math.floor((min + max) / 2);

        // Initialize the jQuery UI slider with midpoint as the initial value
        jQuery(slider).slider({
            range: true,
            min: min,
            max: max,
            values: [0, midpoint],  // Set the initial values to the midpoint and max value
            slide: function(event, ui) {
                // Update hidden inputs and live display values in real-time as slider is adjusted
                document.getElementById('input-min').value = ui.values[0];
                document.getElementById('input-max').value = ui.values[1];

                // Update the display values dynamically as the slider is moved
                document.getElementById('slider-value').innerText = `${ui.values[0]} - ${ui.values[1]}`; 
            },
            change: function(event, ui) {
                // Dispatch updated min/max values to Livewire when the slider stops moving
                Livewire.dispatch('updateSliersPrice', [ui.values[0], ui.values[1]]);
            }
        });

        // Initially update the display value on page load to midpoint
        document.getElementById('slider-value').innerText = `${midpoint} - ${max}`;

        // Initialize hidden inputs with the starting values
        document.getElementById('input-min').value = 0;
        document.getElementById('input-max').value = midpoint;
    });
</script>
@endpush