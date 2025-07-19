<div>
                    
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a title="Go to Home Page" href="{{ route('front.index') }}">Home</a><span>&raquo;</span></li>           
            <li><strong>Compare</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumbs End --> 
 <!-- Main Container --> 
 <section class="main-container col1-layout">
    <div class="main container">
        <div class="col-main">
            <div class="compare-list">
                <div class="page-title">
                    @if(count($products) > 0)
                        <h2>Compare Products</h2>
                    @else
                        <h2>No products in compare list</h2>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-compare" style="table-layout: fixed; width: 100%;">
                        <!-- Product Images Row -->
                        <tr>
                            <td class="compare-label">Product Image</td>
                            @foreach($products as $product)
                                <td>
                                    <a href="{{ route('product.details', $product->slug) }}" target="_blank">
                                        <img src="{{ asset('front/images/products/'.$product->photo) }}" alt="Product" class="img-fluid">
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                        
                        <!-- Product Name Row -->
                        <tr>
                            <td class="compare-label">Product Name</td>
                            @foreach($products as $product)
                                <td><a href="javascript:;">{{ $product->name }}</a></td>
                            @endforeach
                        </tr>

                        <!-- Rating Row -->
                        <tr>
                            <td class="compare-label">Rating</td>
                            @foreach($products as $product)
                                <td>
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa {{ $i <= $product->ratings->avg('rating') ? 'fa-star' : 'fa-star-o' }}"></i>
                                        @endfor
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        <!-- Price Row -->
                        <tr>
                            <td class="compare-label">Price</td>
                            @foreach($products as $product)
                                <td class="price">
                                    @php
                                        
                                        $productTotal = $productTotals[$product->id] ?? $product->price;
                                        $previousTotal = $previousTotals[$product->id] ?? $product->previous_price;
                        
                                        
                                        $formattedTotal = $productTotal ? round($productTotal * $current_currency->value, 2) : round($previousTotal * $current_currency->value, 2);
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
                                </td>
                            @endforeach
                        </tr>

                        <!-- Description Row -->
                        <tr>
                            <td class="compare-label">Description</td>
                            @foreach($products as $product)
                                <td>{!! $product->details !!}</td>
                            @endforeach
                        </tr>

                        <!-- Variations Row -->
                        <tr>
                           
                                <td class="compare-label">Variations</td>
                                
                                @foreach($products as $product)
                                <td>
                                @if(!empty($product->attributes))
                                <div class="product-variation"style="border-bottom:none;padding:10px;background:#f5f5f5;border-radius:10px;" x-data="{openVariations:false}">
                                  <h2 class="saider-bar-title" style="border-bottom:none;">Product Variatins <span class="pull-right" @click="openVariations = !openVariations"><i class="fa fa-angle-down" style="font-size:18px;font-weight:600;" x-show="!openVariations" x-cloak></i> <i class="fa fa-angle-up" style="font-size:18px;font-weight:600;" x-show="openVariations" x-cloak></i></span></h2>
                                  <div class="war-show" x-show="openVariations" x-cloak>
                                  @foreach(json_decode($product->attributes,true) as $key=>$attribute)
                                  <div class="width" x-data="{openVariation{{ $key }}:false}">
                                  <div class="size-area">
                                      <h2 class="saider-bar-title" @click="openVariation{{ $key }} = !openVariation{{ $key }}">{{ Str::title(str_replace("_", " ", $key)) }} : <span class="pull-right" style="cursor:pointer;"><i class="fa fa-plus" x-show="!openVariation{{ $key }}" x-cloak></i> <i class="fa fa-minus" x-show="openVariation{{ $key }}" x-cloak></i></span></h2>
                                    
                                          <ul style="list-style: none; padding: 0; margin: 0;" x-show="openVariation{{ $key }}" x-cloack>
                                          <div class="row">
                  
                                         
                                              @foreach ($attribute['values'] as $optionKey => $optionVal)
                                              <div class="col-md-4 col-xs-12">
                                                  <li style="margin-bottom: 8px;">
                                                    <label for="attrValue{{ $optionVal }}">
                                                      <input type="radio" 
                                                             id="attrValue{{ $optionVal }}" 
                                                             value="{{ $attribute['prices'][$optionKey] }}" 
                                                             name="attrValeu{{$key}}" 
                                                             wire:click="incrementProductPrice('{{ $key }}','{{ $attribute['prices'][$optionKey] }}','{{ $product->id }}')">
                                                  
                                                      {{ $optionVal }} 
                                                      @if (!empty($attribute['prices'][$optionKey]))
                                                          +
                                                          @php
                                                          $optionPrice = $attribute['prices'][$optionKey] * $current_currency->value;
                                                          $formattedTotal = $optionPrice ? round($optionPrice, 2) : '0.00';
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
                                                         
                                                      @endif
                                                  </label>      
                                                  </li>
                                              </div>
                                            
                                              @endforeach
                                          </div>
                                          </ul>
                                    
                                    </div>
                                  </div>
                                  @endforeach
                              </div>
                              </div>
                              @endif 
                                @endforeach
                            </td>
                        </tr>

                        <!-- Availability Row -->
                        <tr>
                            <td class="compare-label">Availability</td>
                            @foreach($products as $product)
                                <td class="instock"> @if(!$product->emptyStock()) Available @else Unabavailable @endif </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="compare-label">Color</td>
                            @foreach($products as $product)
                            @if(!empty($product->color))
                            <td>
                                
                                <div class="size-area">
                                  <h2 class="saider-bar-title">color</h2>
                                  <div class="size">
                                    <ul style="list-style:none;">
                                    @foreach($product->color as $color)
                                      <li style="background:{{ $color }}"><a href="javascript: ;"></a></li>
                                    @endforeach
                                     
                                    </ul>
                                  </div>
                                </div>
                                
                            </td>
                        @else       
                            <td>No color attributes assigned</td>
                        @endif
                            @endforeach
                        </tr>

                        <!-- Size Row -->
                        <tr>
                            <td class="compare-label">Size</td>
                            @foreach($products as $product)
                          
                             @if(!empty($product->size))
                                <td>
                                    
                                    <div class="size-area">
                                      <h2 class="saider-bar-title">Size</h2>
                                      <div class="size">
                                        <ul style="list-style:none;">
                                        @foreach($product->size as $size)
                                          <li><a href="javascript: ;">{{ $size }}</a></li>
                                        @endforeach
                                         
                                        </ul>
                                      </div>
                                    </div>
                                    
                                </td>
                            @else       
                                <td>No size attributes assigned</td>
                            @endif
                            @endforeach
                        </tr>

                        <!-- Dimensions Row -->
                       

                        <!-- Action Row -->
                        <tr>
                            <td class="compare-label">Action</td>
                            @foreach($products as $product)
                                <td class="action">
                                    <button class="add-cart button button-sm" wire:click="addToCart('{{ $product->id }}')">
                                        <i class="fa fa-shopping-cart"></i>
                                    </button>
                                    <button class="button button-sm" wire:click="addToWishlist('{{ $product->id }}')">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                    <button class="button button-sm" wire:click="removeFromCompare('{{ $product->id }}')">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


 
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
  
</div>
