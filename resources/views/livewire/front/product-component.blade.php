<div>
     
  
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a title="Home" href="{{ route('front.index') }}">Home</a><span>&raquo;</span></li>
            <li class=""> <a title="{{ $productDetails->name }}" href="">Product Details</a><span>&raquo;</span></li>
            <li><strong>{{ $productDetails->category->name }}</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumbs End --> 
  <!-- Main Container -->
  <div class="main-container col1-layout">
    <div class="container">
      <div class="row">
        <div class="col-main">
          <div class="product-view-area">
            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5" wire:ignore>
              <div class="icon-sale-label sale-left">Sale</div>
              <div class="large-image">
                 <a href="{{ asset('images/products/'.$productDetails->photo) }}" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20">
                     <img class="zoom-img" src="{{ asset('assets/images/products/'.$productDetails->photo) }}" alt="products">
                 </a> 
                </div>
              <div class="flexslider flexslider-thumb">
                <ul class="previews-list slides">
                @foreach($productDetails->galleries as $gallery)
                  <li>
                    <a href='{{ asset('assets/images/galleries/'.$gallery->photo) }}' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '{{ asset('assets/images/galleries/'.$gallery->photo) }}' ">
                        <img src="{{ asset('assets/images/galleries/'.$gallery->photo) }}" alt = "Thumbnail 2" height="100"/>
                    </a>
                 </li>
                @endforeach
                <li>
                    <a href='{{ asset('assets/images/products/'.$productDetails->photo) }}'  class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '{{ asset('assets/images/products/'.$productDetails->photo) }}' ">
                        <img src="{{ asset('assets/iassets/mages/products/'.$productDetails->photo) }}" alt = "Thumbnail 2" height="100"/>
                    </a>
                 </li>
                </ul>
              </div>
              
              <!-- end: more-images --> 
              
            </div>
            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7 product-details-area">
              <div class="product-name">
                <h1>{{ $productDetails->name }}</h1>
              </div>
              <div class="price-box">
                <p class="special-price">
                    <span class="price-label">Special Price</span>
                    <span class="price">
                      @php
                      $formattedTotal = $productTotal ? round($productTotal,2) : round($productDetails->previous_price,2);
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
                </p>
            
                <p class="old-price">
                    <span class="price-label">Regular Price:</span>
                    <span class="price">
                      @php
                      $formattedTotal = $previousTotal ? round($previousTotal,2) : round($productDetails->previous_price,2);
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
                </p>
            </div>
            
              <div class="ratings">
                <div class="rating">
                    <!-- Loop to create filled stars -->
                 
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa {{ $i <= $productDetails->ratings->avg('rating') ? 'fa-star' : 'fa-star-o' }}"></i>
                    @endfor
                </div>
                <p class="rating-links"> <a href="single_product.html#">1 Review(s)</a> <span class="separator">|</span> <a href="single_product.html#">Add Your Review</a> </p>
                @if(!$productDetails->emptyStock())
                <p class="availability in-stock pull-right">Availability: <span>In Stock</span></p>
                @else    
                <p class="availability in-stock pull-right">Availability: <span  style="background:gray;">Out of stock </span></p>
                @endif 
              </div>
              <div class="short-description">
                <h4>Buy Conditions</h4>
                {!! $productDetails->policy !!}
              </div>
              <div class="product-color-size-area">
            
              @if(!empty($productDetails->color))
             
                <div class="color-area">
                  <h2 class="saider-bar-title">Color</h2>
                  <div class="color">
                    <ul>
                    @foreach($productDetails->color as $color)
                      <li style="background:{{ $color }};"><a href="javascript: ;"></a></li>
                    @endforeach
                     
                    </ul>
                  </div>
                </div>
                @endif 
                @if(!empty($productDetails->size))
                <div class="size-area">
                  <h2 class="saider-bar-title">Size</h2>
                  <div class="size">
                    <ul>
                    @foreach($productDetails->size as $size)
                      <li><a href="javascript: ;">{{ $size }}</a></li>
                    @endforeach
                     
                    </ul>
                  </div>
                </div>
                @endif 
              </div>
              @if(!empty($productDetails->attributes))
              <div class="product-variation"style="border-bottom:none;padding:10px;background:#f5f5f5;border-radius:10px;" x-data="{openVariations:false}">
                <h2 class="saider-bar-title" >Attributes <span class="pull-right" @click="openVariations = !openVariations"><i class="fa fa-angle-down" style="font-size:18px;font-weight:600;" x-show="!openVariations" x-cloak></i> <i class="fa fa-angle-up" style="font-size:18px;font-weight:600;" x-show="openVariations" x-cloak></i></span></h2>
                <div class="war-show" x-show="openVariations" x-cloak>
                @foreach(json_decode($productDetails->attributes,true) as $key=>$attribute)
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
                                           wire:click="incrementProductPrice('{{ $key }}','{{ $attribute['prices'][$optionKey] }}')">
                                
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
                <div class="product-variation row" style="border-top:none;">
                <div class="qty col-xs-12">
                  <div class="cart-plus-minus">
                    <label for="qty">Quantity:</label>
                    <div class="numbers-row">
                      <div onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) result.value--;return false;" class="dec qtybutton" wire:click="decrementQuantity"><i class="fa fa-minus">&nbsp;</i></div>
                        <input type="text"  class="qty" title="Qty" maxlength="12" wire:model="productQuantity"  id="qty">
                      <div onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="inc qtybutton" wire:click="incrementQuantity"><i class="fa fa-plus">&nbsp;</i></div>
                    </div>
                  </div>
                  <button class="button pro-add-to-cart" title="Add to Cart" type="button" wire:click="addToCart('{{ $productDetails->id }}')"><span><i class="fa fa-shopping-cart" ></i> Add to Cart</span></button>
                </div>
              </div>
              <div class="product-cart-option">
                <ul>
                  <li><a href="javascript:;" wire:click="addToWishlist('{{ $productDetails->id }}')"><i class="fa fa-heart"></i><span>Add to Wishlist</span></a></li>
                  <li><a href="javascript: ;" wire:click="addToCompare('{{ $productDetails->id }}')"><i class="fa fa-retweet"></i><span>Add to Compare</span></a></li>
                  <li><a href="single_product.html#"><i class="fa fa-envelope"></i><span>Email to a Friend</span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="product-overview-tab">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <div class="product-tab-inner">
                  <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                    <li @if(Session::has('openProperty')) @if(Session::get('openProperty')=='description') class="active" @endif @endif @if(!Session::has('openProperty')) class="active" @endif  > <a href=#description" data-toggle="tab" wire:click="setOpenProperty('description')"> Description </a> </li>
                    <li @if(Session::has('openProperty')) @if(Session::get('openProperty')=='reviews') class="active" @endif @endif > <a href="#reviews" data-toggle="tab" wire:click="setOpenProperty('reviews')">Reviews</a> </li>
                    <li @if(Session::has('openProperty')) @if(Session::get('openProperty')=='tags') class="active" @endif @endif><a href="#product_tags" data-toggle="tab" wire:click="setOpenProperty('tags')">Tags</a></li>
                    <li @if(Session::has('openProperty')) @if(Session::get('openProperty')=='custom') class="active" @endif @endif> <a href="#custom_tabs" data-toggle="tab" wire:click="setOpenProperty('custom')">Custom Tab</a> </li>
                  </ul>
                  <div id="productTabContent" class="tab-content">
                    <div class="tab-pane fade in @if(!Session::has('openProperty')) active @endif @if(Session::has('openProperty')) @if(Session::get('openProperty')=='description') active @endif @endif " id="description">
                      <div class="std">
                        <p>Proin lectus ipsum, gravida et mattis vulputate, 
                          tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in 
                          faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend 
                          laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla
                          luctus malesuada tincidunt. Nunc facilisis sagittis ullamcorper. Proin 
                          lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et 
                          lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et 
                          ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus 
                          adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada 
                          tincidunt. Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, 
                          gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. 
                          Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
                          cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl 
                          ut dolor dignissim semper. Nulla luctus malesuada tincidunt.</p>
                        <p> Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer enim purus, posuere at ultricies eu, placerat a felis. Suspendisse aliquet urna pretium eros convallis interdum. Quisque in arcu id dui vulputate mollis eget non arcu. Aenean et nulla purus. Mauris vel tellus non nunc mattis lobortis.</p>
                        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempor, lorem et placerat vestibulum, metus nisi posuere nisl, in accumsan elit odio quis mi. Cras neque metus, consequat et blandit et, luctus a nunc. Etiam gravida vehicula tellus, in imperdiet ligula euismod eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. </p>
                      </div>
                    </div>
                    <div id="reviews" class="tab-pane fade @if(Session::has('openProperty')) @if(Session::get('openProperty')=='reviews') active in @endif @endif">
                      <div class="col-sm-5 col-lg-5 col-md-5">
                        <div class="reviews-content-left">
                          <h2>Customer Reviews</h2>
                        @foreach($productRatings as $rating)
                          <div class="review-ratting">
                            <p><a href="single_product.html#">{{ $rating->review_summary }}</a> {{ $rating->review }}</p>
                            <table>
                              <tbody>
                                <tr>
                                  <th>Price</th>
                                  <td><div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= $rating->price ? 'fa-star' : 'fa-star-o' }}"></i>
                                    @endfor
                                     
                                    </div></td>
                                </tr>
                                <tr>
                                  <th>Value</th>
                                  <td><div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= $rating->value ? 'fa-star' : 'fa-star-o' }}"></i>
                                    @endfor
                                 </div>
                                </td>
                                </tr>
                                <tr>
                                  <th>Quality</th>
                                  <td><div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= $rating->quality ? 'fa-star' : 'fa-star-o' }}"></i>
                                    @endfor
                                     </div>
                                </td>
                                </tr>
                              </tbody>
                            </table>
                            <p class="author">{{$rating->nick_name}}<small> (Posted on {{ Carbon\Carbon::parse($rating->created_at)->format($gs->time_format) }})</small> </p>
                          </div>
                          @endforeach
                          
                        </div>
                      </div>
                      <div class="col-sm-7 col-lg-7 col-md-7">
                        <div class="reviews-content-right">
                          <h2>Write Your Own Review</h2>
                          <div class="summary">
                            <h3>You're reviewing: <span>{{ $productDetails->name }}</span></h3>
                            <h4>How do you rate this product?<em>*</em></h4>
                            <div class="table-responsive reviews-table">
                              <table>
                                <tbody>
                                  <tr>
                                    <th></th>
                                    @for($i=1; $i<=5; $i++)
                                    <th>{{ $i }} star</th>
                                    @endfor
                                  
                                  </tr>
                                  <tr>
                                    <td>Quality</td>
                                    @for($i=1; $i<=5; $i++)
                                    <td><input type="radio" name="product_quality" value="{{ $i }}" wire:model="productQuality"></td>
                                    @endfor
                                  
                                  </tr>
                                  <tr>
                                    <td>Price</td>
                                    @for($i=1; $i<=5; $i++)
                                    <td><input type="radio" name="product_price" value="{{ $i }}" wire:model="productPrice"></td>
                                    @endfor
                                   
                                  </tr>
                                  <tr>
                                    <td>Value</td>
                                    @for($i=1; $i<=5; $i++)
                                    <td><input type="radio" name="product_value" value="{{ $i }}" wire:model="productValue"></td>
                                    @endfor
                                  
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="form-area">
                              <div class="form-element">
                                <label>Nickname <em>*</em></label>
                                <input type="text" wire:model="nickName">
                              </div>
                              <div class="form-element">
                                <label>Summary of Your Review <em>*</em></label>
                                <input type="text" wire:model="reviewSummary">
                              </div>
                              <div class="form-element">
                                <label>Review <em>*</em></label>
                                <textarea wire:model="reviewDetails"></textarea>
                              </div>
                              @error('productQuality') <span class="text-danger">{{ $message }}</span> <br> @enderror 
                                @error('productPrice') <span class="text-danger">{{ $message }}</span> <br> @enderror
                                @error('productValue') <span class="text-danger">{{ $message }}</span>  <br> @enderror
                                @error('nickName') <span class="text-danger">{{ $message }}</span> <br>  @enderror 
                                @error('reviewSummary') <span class="text-danger">{{ $message }}</span> <br>  @enderror 
                                @error('reviewDetails') <span class="text-danger">{{ $message }}</span>  <br> @enderror 

                              <div class="buttons-set">
                                <button class="button submit" title="Submit Review" wire:click="submitReview"><span><i class="fa fa-thumbs-up"></i> &nbsp;Review</span></button>
                              </div>
                            </div>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade @if(Session::has('openProperty')) @if(Session::get('openProperty')=='tags') active in @endif @endif " id="product_tags">
                      <div class="box-collateral box-tags">
                        <div class="tags">
                          <form id="addTagForm" action="single_product.html#" method="get">
                            <div class="form-add-tags">
                              <div class="input-box">
                                <label for="productTagName">Add Your Tags:</label>
                                <input class="input-text" name="productTagName" id="productTagName" type="text">
                                <button type="button" title="Add Tags" class="button add-tags"><i class="fa fa-plus"></i> &nbsp;<span>Add Tags</span> </button>
                              </div>
                              <!--input-box--> 
                            </div>
                          </form>
                        </div>
                        <!--tags-->
                        <p class="note">Use spaces to separate tags. Use single quotes (') for phrases.</p>
                      </div>
                    </div>
                    <div class="tab-pane fade @if(Session::has('openProperty')) @if(Session::get('openProperty')=='custom') active in @endif @endif " id="custom_tabs">
                      <div class="product-tabs-content-inner clearfix">
                        <p><strong>Lorem Ipsum</strong><span>&nbsp;is
                          simply dummy text of the printing and typesetting industry. Lorem Ipsum
                          has been the industry's standard dummy text ever since the 1500s, when 
                          an unknown printer took a galley of type and scrambled it to make a type
                          specimen book. It has survived not only five centuries, but also the 
                          leap into electronic typesetting, remaining essentially unchanged. It 
                          was popularised in the 1960s with the release of Letraset sheets 
                          containing Lorem Ipsum passages, and more recently with desktop 
                          publishing software like Aldus PageMaker including versions of Lorem 
                          Ipsum.</span></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Main Container End --> 
  
  <!-- Related Product Slider -->
  
  <div class="container" wire:ignore>
    <div class="row">
      <div class="col-xs-12">
        <div class="related-product-area">
          <div class="page-header">
            <h2>Related Products</h2>
          </div>
          <div class="related-products-pro">
            <div class="slider-items-products">
              <div id="related-product-slider" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4">
                  @foreach($productFromCategory as $relatedProduct)
                  <div class="product-item">
                    <div class="item-inner">
                      <div class="product-thumb has-hover-img">
                        <figure> <a title="Ipsums Dolors Untra" href="{{ route('product.details',$relatedProduct->slug) }}"> 
                          <img class="first-img" src="{{ asset('front/images/products/'.$relatedProduct->photo) }}" alt="">
                           <img class="hover-img" src="{{ asset('front/images/products/'.$relatedProduct->photo) }}" alt=""> </a></figure>
                        <div class="pr-info-area animated animate2"><a href="{{ route('product.details',$relatedProduct->slug) }}" class="quick-view"><i class="fa fa-search">
                          <span>Quick view</span>
                        </i>
                      </a> 
                      <a href="javascript" class="wishlist">
                        <i class="fa fa-heart"><span>Wishlist</span></i>
                      </a> <a href="javascript:;" wire:click="addToCompare('{{ $relatedProduct->id }}')" class="compare">
                        <i class="fa fa-exchange"><span>Compare</span></i></a> </div>
                      </div>
                      <div class="item-info">
                        <div class="info-inner">
                          <div class="item-title"> <h4><a title="Ipsums Dolors Untra" href="{{ route('product.details',$relatedProduct->slug) }}">{{ $relatedProduct->name }} </a>
                          </h4> 
                        </div>
                          <div class="item-content">
                            <div class="rating">
                              @for ($i = 1; $i <= 5; $i++)
                                <i class="fa {{ $i <= $relatedProduct->ratings->avg('rating') ? 'fa-star' : 'fa-star-o' }}"></i>
                              @endfor
                                </div>
                            <div class="item-price">
                              <p class="special-price">
                                <span class="price-label">Special Price</span>
                                <span class="price">
                                  @php
                                  $formattedTotal = $relatedProduct->price ? round($relatedProduct->price * $current_currency->value, 2) : round($relatedProduct->previous_price * $current_currency->value, 2);
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
                            </p>
                        
                            <p class="old-price">
                                <span class="price-label">Regular Price:</span>
                                <span class="price">
                                  @php
                                  $formattedTotal = $relatedProduct->previous_price ? round($relatedProduct->previous_price * $current_currency->value, 2) : round($relatedProduct->previous_price * $current_currency->value, 2);
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
                            </p>
                            </div>
                            <div class="pro-action">
                              <button type="button" class="add-to-cart-mt" wire:click="addToCart('{{ $relatedProduct->id }}')">
                                 <i class="fa fa-shopping-cart"></i><span> Add to Cart</span>
                               </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Related Product Slider End --> 
  
  <!-- Upsell Product Slider -->
  <section class="upsell-product-area" wire:ignore>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="page-header">
            <h2>UpSell Products</h2>
          </div>
          <div class="slider-items-products">
            <div id="upsell-product-slider" class="product-flexslider hidden-buttons">
              <div class="slider-items slider-width-col4">
              @foreach($productFromCategory as $sameCategory)
                <div class="product-item">
                  <div class="item-inner">
                    <div class="product-thumb has-hover-img">
                      <figure> <a title="Ipsums Dolors Untra" href="{{ route('product.details',$sameCategory->slug) }}"> 
                        <img class="first-img" src="{{ asset('front/images/products/'.$sameCategory->photo) }}" alt="">
                         <img class="hover-img" src="{{ asset('front/images/products/'.$sameCategory->photo) }}" alt=""> </a></figure>
                      <div class="pr-info-area animated animate2"><a href="{{ route('product.details',$sameCategory->slug) }}" class="quick-view"><i class="fa fa-search">
                        <span>Quick view</span>
                      </i>
                    </a> 
                    <a href="javascript" class="wishlist">
                      <i class="fa fa-heart"><span>Wishlist</span></i>
                    </a> <a href="javascript:;" wire:click="addToCompare('{{ $sameCategory->id }}')" class="compare">
                      <i class="fa fa-exchange"><span>Compare</span></i></a> </div>
                    </div>
                    <div class="item-info">
                      <div class="info-inner">
                        <div class="item-title"> <h4><a title="Ipsums Dolors Untra" href="{{ route('product.details',$sameCategory->slug) }}">{{ $sameCategory->name }} </a>
                        </h4> 
                      </div>
                        <div class="item-content">
                          <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                              <i class="fa {{ $i <= $sameCategory->ratings->avg('rating') ? 'fa-star' : 'fa-star-o' }}"></i>
                            @endfor
                              </div>
                          <div class="item-price">
                            <p class="special-price">
                              <span class="price-label">Special Price</span>
                              <span class="price">
                                @php
                                $formattedTotal = $sameCategory->price ? round($sameCategory->price * $current_currency->value, 2) : round($sameCategory->previous_price * $current_currency->value, 2);
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
                          </p>
                      
                          <p class="old-price">
                              <span class="price-label">Regular Price:</span>
                              <span class="price">
                                @php
                                $formattedTotal = $sameCategory->previous_price ? round($sameCategory->previous_price * $current_currency->value, 2) : round($sameCategory->previous_price * $current_currency->value, 2);
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
                          </p>
                          </div>
                          <div class="pro-action">
                            <button type="button" class="add-to-cart-mt" wire:click="addToCart('{{ $sameCategory->id }}')">
                               <i class="fa fa-shopping-cart"></i><span> Add to Cart</span>
                             </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
             
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

 
</div>
