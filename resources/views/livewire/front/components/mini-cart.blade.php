<div>
    
      <div class="mini-cart">
        <div data-toggle="dropdown" data-hover="dropdown" class="basket dropdown-toggle"> <a href="index.html#">
          <div class="cart-icon"><i class="fa fa-shopping-cart"></i></div>
          <div class="shoppingcart-inner hidden-xs hidden-sm"><span class="cart-title">Shopping Cart</span> <span class="cart-total">{{ $cartCount }} Item(s):
            @php
            $formattedTotal = $cartTotal ? round($cartTotal, 2) : '0.00';
            $currencySymbol = $current_currency->sign ?? $current_currency->name; 
            @endphp

            @if($gs->currency_format)
        
                @if($current_currency->sign)
                  
                    {{ $formattedTotal }} {{ $current_currency->sign }}
                @else
              
                    {{ $formattedTotal }} {{ $current_currency->name }}
                @endif
            @else

                @if($current_currency->sign)
                
                    {{ $current_currency->sign }} {{ $formattedTotal }}
                @else
                    
                    {{ $formattedTotal }} {{ $current_currency->name }} 
                @endif
            @endif
            </span>
          </div>
          </a></div>
        <div>
          <div class="top-cart-content">
            <div class="block-subtitle">{{ $cartCount > 0 ? 'Recently added item(s)' : 'No Items in cart' }}</div>
            @if($cartCount > 0)
            <ul id="cart-sidebar" class="mini-products-list">
          
            @foreach($cartItems as $item)
      
            <li class="item odd">
              @php
                  // Retrieve the product only once to avoid multiple database calls
                  $product = \App\Models\Product::find($item['product_id']);
                  $formattedPrice = round($item['price'], 2);
          
                  // Check if the currency has a sign and set the display symbol accordingly
                  $currencySymbol = $current_currency->sign ?: $current_currency->name;
              @endphp
          
              <a href="{{ route('product.details', $product->slug) }}" title="{{ $product->name }}" class="product-image">
                  <img src="{{ asset('front/images/products/' . $product->photo) }}" alt="{{ $product->name }}" width="65">
              </a>
              <div class="product-details">
                  <a href="javascript:;" wire:click="removeCartItem('{{ $item['cart_key'] }}')" title="Remove This Item" class="remove-cart">
                      <i class="icon-close"></i>
                  </a>
                  <p class="product-name">
                      <a href="{{ route('product.details', $product->slug) }}">
                        {{ \Illuminate\Support\Str::limit($product->name, 45) }}  
                      </a>
                  </p>
                  <strong>{{ $item['quantity'] }}</strong> x 
                  <span class="price">
                    @php
                    $formattedTotal = $formattedPrice ? round($formattedPrice, 2) : '0.00';
                    $currencySymbol = $current_currency->sign ?? $current_currency->name; // Choose sign or name
                    @endphp
            
                    @if($gs->currency_format)
                
                        @if($current_currency->sign)
                          
                            {{ $formattedTotal }} {{ $current_currency->sign }}
                        @else
                      
                            {{ $formattedTotal }} {{ $current_currency->name }}
                        @endif
                    @else
            
                        @if($current_currency->sign)
                        
                            {{ $current_currency->sign }} {{ $formattedTotal }}
                        @else
                            
                            {{ $formattedTotal }} {{ $current_currency->name }} 
                        @endif
                    @endif
                  </span>
              </div>
          </li>
          
          
          
            @endforeach
          
            </ul>
            @endif 
            @if($cartCount > 0)
            <div class="top-subtotal">
              Subtotal: 
              <span class="price">
                  @php
                      $formattedTotal = $cartTotal ? round($cartTotal, 2) : '0.00';
                      $currencySymbol = $current_currency->sign ?? $current_currency->name; // Choose sign or name
                  @endphp
          
                  @if($gs->currency_format)
               
                      @if($current_currency->sign)
                        
                          {{ $formattedTotal }} {{ $current_currency->sign }}
                      @else
                     
                          {{ $formattedTotal }} {{ $current_currency->name }}
                      @endif
                  @else
          
                      @if($current_currency->sign)
                      
                          {{ $current_currency->sign }} {{ $formattedTotal }}
                      @else
                          
                          {{ $formattedTotal }} {{ $current_currency->name }} 
                      @endif
                  @endif
              </span>
          </div>
          
          <div class="actions">
              <button class="btn-checkout" type="button">
                <a href="{{ route('proceed.checkout') }}">
                    <i class="fa fa-check"></i> <span>Checkout</span>
                </a>
              </button>
              <button class="view-cart" type="button">
                  <a href="{{ route('view.cart') }}">
                      <i class="fa fa-shopping-cart"></i> <span>View Cart</span>
                  </a>
              </button>
          </div>
          
        @endif
        </div>
      </div>
      <livewire:front.components.dispatcher/>
</div>
