<div>

  <!-- Main Container -->
  <section class="main-container col1-layout">
    <div class="main container">
      <div class="col-main">
        <div class="cart">
          
          <div class="page-content page-order">
            <div class="page-title">
              <h2>Shopping Cart</h2>
            </div>

            <div class="order-detail-content">
              <div class="table-responsive">
                <table class="table table-bordered cart_summary">
                  <thead>
                    <tr>
                      <th class="cart_product">Product</th>
                      <th>Description</th>
                      <th>Avail.</th>
                      <th>Unit price</th>
                      <th>Qty</th>
                      <th>Total</th>
                      <th class="action" wire:click="clearShoppingCart"><i class="fa fa-trash-o"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(session()->has('cart.items'))
                      @foreach($cartItems as $item)
                        
                        <tr>
                          <td class="cart_product">
                            <a href="{{ route('product.details', \App\Models\Product::find($item['product_id'])->slug) }}">
                              <img src="{{ asset('front/images/products/' . \App\Models\Product::find($item['product_id'])->photo) }}" alt="Product">
                            </a>
                          </td>
                          <td class="cart_description" x-data="{ variationsOpen{{ str_replace($item['cart_key'],'-','') }}: false }">
                            <p>{{ \App\Models\Product::find($item['product_id'])->name }}</p>
                            @if(!empty($item['attributes']))
                              <hr>
                              <h3 class="product-name">
                                <a href="javascript: ;" @click="variationsOpen{{ str_replace($item['cart_key'],'-','') }} = !variationsOpen{{ str_replace($item['cart_key'],'-','') }}">
                                  Attributes
                                  <span class="pull-right">
                                    <i class="fa fa-angle-down" x-show="!variationsOpen{{ str_replace($item['cart_key'],'-','') }}" x-cloak></i>
                                    <i class="fa fa-angle-up" x-show="variationsOpen{{ str_replace($item['cart_key'],'-','') }}" x-cloak></i>
                                  </span>
                                </a>
                              </h3>
                              <div class="variations" x-show="variationsOpen{{ str_replace($item['cart_key'],'-','') }}" x-cloak>
                                @foreach($item['attributes'] as $key => $variation)
                                  <div class="variation">
                                    <span>{{ Str::title(str_replace("_", " ", $key)) }}:</span>
                                    <span>
                                      @php
                                      $formattedTotal = $variation ? round($variation * $current_currency->value, 2) : '0.00';
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
                                @endforeach
                              </div>
                            @endif
                            <hr>
                   
                          </td>
                          <td class="availability in-stock"><span class="label">In stock</span></td>

                          <!-- Unit price (converted to current currency) -->
                          <td class="price">
                            <span>
                              @php
                              $formattedTotal = $item['price'] ? round($item['price'], 2) : '0.00';
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
                          </td>

                          <!-- Quantity Input -->
                          <td class="qty">
                            <input class="form-control input-sm"                                  
                                   wire:change="updateQuantity('{{ $item['cart_key'] }}', $event.target.value)"
                                   value="{{ $item['quantity'] }}" 
                                   type="number" 
                                   min="1">
                        </td>
                        

                          <!-- Total for this item (quantity * price) -->
                          <td class="price">
                            <span>
                              @php
                              $formattedTotal = $item['price'] ? round(($item['price']*$item['quantity']), 2) : '0.00';
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
                          </td>

                          <!-- Remove item -->
                          <td class="action">
                            <a href="javascript: ;" wire:click="removeCartItem('{{ $item['cart_key'] }}')">
                              <i class="icon-close"></i>
                            </a>
                          </td>
                        </tr>

                      @endforeach 
                    @endif 
                  </tbody>

                  <tfoot>
                    <tr>
                      <td colspan="2" rowspan="2"></td>
                      <td colspan="3">Total products (tax incl.)</td>
                      <td colspan="2">
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
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3"><strong>Total</strong></td>
                      <td colspan="2"><strong>
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
                      </strong></td>
                    </tr>
                  </tfoot>
                </table>
              </div>

              <!-- Cart Navigation -->
              <div class="cart_navigation">
                <a class="continue-btn" href="{{ route('front.index') }}">
                  <i class="fa fa-arrow-left"></i>&nbsp; Continue shopping
                </a> 
                <a class="checkout-btn" href="{{ route('proceed.checkout') }}">
                  <i class="fa fa-check"></i> Proceed to checkout
                </a> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Service Section -->
  <div class="jtv-service-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-sm-4 col-xs-12">
          <div class="jtv-service">
            <div class="ser-icon">
              <i class="fa fa-truck flip-horizontal"></i> 
            </div>
            <div class="service-content">
              <h5>FREE SHIPPING WORLDWIDE</h5>
              <p>Free shipping on orders over $299.00</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-12">
          <div class="jtv-service">
            <div class="ser-icon">
              <i class="fa fa-mail-forward"></i>
            </div>
            <div class="service-content">
              <h5>MONEY BACK GUARANTEE!</h5>
              <p>30 days money back guarantee!</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-12">
          <div class="jtv-service">
            <div class="ser-icon">
              <i class="fa fa-comments flip-horizontal"></i>
            </div>
            <div class="service-content">
              <h5>24/7 CUSTOMER SERVICE</h5>
              <p>We support online 24 hours a day</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<livewire:front.components.dispatcher/>
</div>
