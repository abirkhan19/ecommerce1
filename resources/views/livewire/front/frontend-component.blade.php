<div >
        
  <div class="main-slideshow" wire:ignore >
    <div class="home-slider">
      <div class="wpb_wrapper">
        <div class="wpb_revslider_element wpb_content_element">
          <div id="rev_slider_6_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" style="margin:0px auto;background-color:#eee;padding:0px;margin-top:0px;margin-bottom:0px;"> 
            <!-- START REVOLUTION SLIDER 5.0.5 auto mode -->
            <div id="rev_slider_6_1" class="rev_slider fullwidthabanner tp-overflow-hidden" style="display:none;" data-version="5.0.5">
              <ul>
                @foreach($sliders as $slider)
                <!-- SLIDE  -->
                <li data-index="rs-{{ $slider->id }}" data-transition="3dcurtain-horizontal,3dcurtain-vertical,cube,cube-horizontal" data-slotamount="7,7,7,7"  data-easein="default,default,default,default" data-easeout="default,default,default,default" data-masterspeed="600,600,600,600" data-rotate="0,0,0,0"  data-saveperformance="off"  data-title="Slide-8" data-description=""> 
                  <!-- MAIN IMAGE --> 
                  <img src="{{ asset('front/images/slider/'.$slider->photo) }}"  alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina> 
                  <!-- LAYERS --> 
                  <!-- LAYER NR. 1 -->
                  <div class="tp-caption black lft tp-resizeme" data-x="center" data-hoffset="200" data-y="center" data-voffset="-90" data-speed="300" data-start="1000" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 5; max-width: auto; max-height: auto; white-space: nowrap;">
                    <p class="text-center" style="font-size: {{ $slider->title_size }}px; color: {{ $slider->title_color }}; font-weight: bold; letter-spacing: 1px; text-transform: uppercase;"> {{ $slider->title_text }} </p>
                  </div>
                  
                  <!-- LAYER NR. 3 -->
                  <div class="tp-caption black skewfromrightshort tp-resizeme" data-x="center" data-hoffset="200" data-y="center" data-voffset="-40" data-speed="300" data-start="1100" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 7; max-width: auto; max-height: auto; white-space: nowrap;">
                    <h1 class="text-center" style="font-size: {{ $slider->subtitle_size }}px; color: {{ $slider->subtitle_color }}; font-weight: bold; text-transform: uppercase;">{{ $slider->subtitle_text }}</h1>
                  </div>
                  
                  <!-- LAYER NR. 6 -->
                  <div class="tp-caption black skewfromleft tp-resizeme" data-x="center" data-hoffset="200" data-y="center" data-voffset="20" data-speed="300" data-start="1200" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 10; max-width: auto; max-height: auto; white-space: nowrap;">
                    <p class="text-center" style="font-style: italic; font-size: {{ $slider->details_size }}px; color: {{ $slider->details_color }};"> {{ $slider->details_text }}
                      </p>
                  </div>
                  <!-- LAYER NR. 7 -->
                  <div class="tp-caption black skewfromright tp-resizeme" data-x="center" data-hoffset="200" data-y="center" data-voffset="90" data-speed="300" data-start="1600" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="300" style="z-index: 11; max-width: auto; max-height: auto; white-space: nowrap;"> 
                    <a href="index.html#" class="btn outline btn-white" style="font-size: 12px; border:none; background:{{ $slider->button_1_bg }};color:{{ $slider->button_1_color }};" target="_blank">{{ $slider->button_1_text }}</a> 
                    <a href="index.html#" class="btn outline btn-white" style="font-size: 12px; border:none; background:{{ $slider->button_2_bg }};color:{{ $slider->button_2_color }};" target="_blank">{{ $slider->button_2_text }} </a>
                 </div>
                </li>
                <!--SLIDE  -->
                @endforeach
              
                
              </ul>
              <div class="tp-bannertimer" style="visibility: hidden !important;"></div>
            </div>
          </div>
          <!-- END REVOLUTION SLIDER --></div>
      </div>
    </div>
    <!-- .fullwidth-slider --> 
    
    <!-- .slide-slider-nav --> 
  </div>
  <!-- End home section --> 
  <!-- service section -->
  
  <div class="jtv-service-area" wire:ignore>
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

@if($ps->featured==1)

  <!--special-products-->
  <div class="container" wire:ignore>
    <div class="special-products">
      <div class="page-header">
        <h2>Discounted Products</h2>
      </div>
      <div class="special-products-pro">
        <div class="slider-items-products">
          <div id="special-products-slider" class="product-flexslider hidden-buttons">
            <div class="slider-items slider-width-col4">
            @foreach($discounted_products as $discounted_product)
              <div class="product-item">
                <div class="item-inner">
                  <div class="product-thumb has-hover-img">
                    <a title="Ipsums Dolors Untra" href="{{ route('product.details',$discounted_product->slug) }}">
                      <figure>
                        <img src="{{ asset('front/images/products/'.$discounted_product->photo) }}" alt="">
                        <img class="hover-img" src="{{ asset('front/images/products/'.$discounted_product->photo) }}" alt="">
                      </figure>
                    </a>
                    <div class="pr-info-area animated animate2">
                      <a href="{{ route('product.details',$discounted_product->slug) }}" class="quick-view">
                        <i class="fa fa-search"><span>Quick view</span></i>
                      </a>
                      <a href="wishlist.html" class="wishlist">
                        <i class="fa fa-heart"><span>Wishlist</span></i>
                      </a>
                      <a href="compare.html" class="compare">
                        <i class="fa fa-exchange"><span>Compare</span></i>
                      </a>
                    </div>
                  </div>
                  <div class="item-info">
                    <div class="info-inner">
                      <div class="item-title">
                        <h4><a title="Ipsums Dolors Untra" href="{{ route('product.details',$discounted_product->slug) }}">
                          {{ strlen($discounted_product->name > 45)  ? \Illuminate\Support\Str::limit($discounted_product->name, 45).'...' : $discounted_product->name}}
                        </a></h4>
                      </div>
                      <div class="item-content">
                        <div class="rating">
                          @for ($i = 1; $i <= 5; $i++)
                          <i class="fa {{ $i <= $discounted_product->ratings->avg('rating') ? 'fa-star' : 'fa-star-o' }}"></i>
                      @endfor
                        </div>
                        <div class="item-price">
                          <div class="price-box">
                            <span class="regular-price">
                              <span class="price">
                                @php
                                $formattedTotal = $discounted_product->price ? round($discounted_product->price * $current_currency->value, 2) : '0.00';
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
                            </span>
                          </div>
                        </div>
                        <div class="pro-action">
                          <button type="button" class="add-to-cart-mt" wire:click="addToCart('{{ $discounted_product->id }}')">
                            <i class="fa fa-shopping-cart" ></i><span> Add to Cart</span>
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
  
@endif 
@if($ps->large_banner==1)
  <!-- end main container -->
  <div class="container" wire:ignore>
    <div class="block-static2-inner">
      <div class="img"><a href="index.html#"><img class="alignnone size-full" src="{{ asset('assets/images/banners/'.$large_banners->photo) }}" alt="banner8"></a></div>
      <div class="content">
        <h3>big offer 2022</h3>
        <h2>45% off</h2>
        <p>Lorem Ipsum is simply dummy text. </p>
      </div>
      <div class="trending">
        <div class="trending-inner">
          <h3>Creative</h3>
          <h2>HUGE SALE</h2>
          <p>New Design </p>
        </div>
      </div>
    </div>
  </div>
@endif
  <!-- main container -->
  <div class="main-container col1-layout" wire:ignore>
    <div class="container">
      <div class="row"> 
        
        <!-- Home Tabs  -->
        <div class="col-sm-8 col-md-9 col-xs-12">
          <div class="home-tab">
            <ul class="nav home-nav-tabs home-product-tabs">
            @foreach($categories->where('is_tabable',1) as $category)
            @if($category->products->count() > 0)
              <li class="{{ $loop->first ? 'active' : '' }}"><a href="#category-tab{{ $category->id }}" data-toggle="tab" aria-expanded="false">{{ $category->name }}</a></li>
            @endif
            @endforeach
            </ul>
            <div id="productTabContent" class="tab-content">
            @foreach($categories->where('is_tabable') as $categoryTab) 
              <div class="tab-pane {{ $loop->first ? 'active in' :'' }}" id="category-tab{{ $categoryTab->id }}">
                <div class="featured-pro">
                  <div class="slider-items-products">
                    <div id="featured-slider" class="product-flexslider hidden-buttons">
                      <div class="slider-items slider-width-col4">
                      @foreach($categoryTab->products as $tabProduct)
                        <div class="product-item">
                          <div class="item-inner">
                            <div class="product-thumb has-hover-img">
                              <div class="icon-sale-label sale-left">Sale</div>
                              <div class="icon-new-label new-right"><span>New</span></div>
                              <figure> <a href="{{ route('product.details',$tabProduct->slug) }}"><img src="{{ asset('assets/images/products/'.$tabProduct->photo) }}" alt=""></a> 
                                <a class="hover-img" href="{{ route('product.details',$tabProduct->slug) }}"><img src="{{ asset('assets/images/products/'.$tabProduct->photo) }}" alt="">
                                </a>
                              </figure>
                              <div class="pr-info-area animated animate2"><a href="{{ route('product.details',$tabProduct->slug) }}" class="quick-view"><i class="fa fa-search"><span>Quick view</span></i></a> 
                                <a href="wishlist.html" class="wishlist"><i class="fa fa-heart"><span>Wishlist</span></i></a> 
                                <a href="javascript:;" class="compare" wire:click="addToCompare('{{ $tabProduct->slug }}')"><i class="fa fa-exchange"><span>Compare</span></i></a> 
                              </div>
                            </div>
                            <div class="item-info">
                              <div class="info-inner">
                                <div class="item-title">
                                  <h4><a title="{{ $tabProduct->name }}" href="{{ route('product.details',$tabProduct->slug) }}">{{ strlen($tabProduct->name) > 20 ? \Illuminate\Support\Str::limit($tabProduct->name, 45).'...' : ''  }} </a></h4>
                                </div>
                                <div class="item-content">
                                  <div class="rating"> 
                                    @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= $tabProduct->ratings->avg('rating') ? 'fa-star' : 'fa-star-o' }}"></i>
                                    @endfor
                                     </div>
                                  <div class="item-price">
                                    <div class="price-box"> <span class="regular-price"> <span class="price">
                                      @php
                                      $formattedTotal = $tabProduct->price ? round($tabProduct->price * $current_currency->value, 2) : '0.00';
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
                                    </span> </span> </div>
                                  </div>
                                  <div class="pro-action">
                                    <button type="button" class="add-to-cart-mt" wire:click="addToCart('{{ $tabProduct->id }}')"> <i class="fa fa-shopping-cart"></i><span> Add to Cart</span> </button>
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
              @endforeach
           
            </div>
          </div>
        </div>
        @if($ps->small_banner==1)
        <div class="col-md-3 col-sm-4 col-xs-12" wire:ignore>
          <div class="jtv-banner-top">
            <div class="jtv-banner-box">
              <div class=""> <a class="jtv-banner-inner-text" href="index.html#">
                <div class="jtv-text">
                  <p class="animated animate1"><span>sale up to</span><span>25% off</span></p>
                  <p class="animated animate2">On selected products</p>
                </div>
                <div class="jtv-banner-box-image"> <img src="{{ asset('assets/images/banners/'.$top_small_banners->photo) }}" alt="Catbox-Images"> </div>
                </a> </div>
            </div>
            <!-- End jtv-banner-box --> 
          </div>
        </div>
        @endif 
      </div>
    </div>
  </div>
  @if($ps->small_banner==1)
  <div class="top-banner" wire:ignore>
    <div class="container">
      <div class="row">
      @foreach($bottom_small_banners->where('style','middle')->take(1) as $bottom_middle_banner)
        <div class="col-sm-6">
          <div class="jtv-banner3">
            <div class="jtv-banner3-inner"><a href="javascript:;"><img src="{{ asset('assets/images/banners/'.$bottom_middle_banner->photo) }}" alt=""></a>
              <div class="hover_content">
                <div class="hover_data">
                  <div class="title"> new trend </div>
                  <div class="desc-text"> Lorem ipsum dolor sit</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <div class="col-sm-6">
        @foreach($bottom_small_banners->where('style','beside')->take('2') as $bottom_small_banner)
          <div class="jtv-banner{{ $loop->index }}"><a href="javascript:;"><img src="{{ asset('assets/images/banners/'.$bottom_small_banner->photo) }}" alt=""></a>
            <div class="hover_content">
              <div class="hover_data">
                <div class="title"> Season sale </div>
                <div class="desc-text"> offer </div>
                <div class="shop-now"><a href="index.html#">Shop now</a></div>
              </div>
            </div>
          </div>
        @endforeach
        </div>
      </div>
    </div>
  </div>
  @endif
  @if($ps->best==1)
  <!-- category area start -->
  <div class="jtv-category-area" wire:ignore>
    <div class="container">
      <div class="row"> <!-- banner -->
     
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="jtv-banner">
            <div class="upper">
            @foreach($bottom_small_banners->where('style','jwt')->take(2) as $small_jwt_banner)
              <div class="jtv-subbanner1"><a href="index.html#"><img class="img-respo" alt="jtv-subbanner1" src="{{ asset('assets/images/banners/'.$small_jwt_banner->photo) }}"></a>
                <div class="text-block">
                 
                </div>
              </div>
            @endforeach
            
            </div>
          </div>
        </div>
        <div class="col-md-8 col-sm-12 col-xs-12" wire:ignore>
          <div class="jtv-single-cat">
            <div class="page-header">
              <h2>Best sale of week</h2>
            </div>
            @foreach($best_products->take(6) as $bestProduct)
            <div class="jtv-product">
              <div class="product-img"> <a href="{{ route('product.details',$bestProduct->slug) }}"> <img src="{{ asset('assets/images/products/'.$bestProduct->photo) }}" alt="">
                 <img class="secondary-img" src="{{ asset('assets/images/products/'.$bestProduct->photo) }}" alt=""> </a> </div>
              <div class="jtv-product-content">
                <h3><a href="{{ route('product.details',$bestProduct->slug) }}">{{ strlen($bestProduct->name > 45)  ? \Illuminate\Support\Str::limit($bestProduct->name, 45).'...' : $bestProduct->name}}  </a></h3>
                <div class="price-box"> <span class="regular-price"> <span class="price">
                  @php
                  $formattedTotal = $bestProduct->price ? round($bestProduct->price * $current_currency->value, 2) : '0.00';
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
                </span> </span> </div>
                <div class="jtv-product-action">
                  <div class="jtv-extra-link">
                    <div class="button-cart">
                      <button wire:click="addToCart('{{ $bestProduct->id }}')"><i class="fa fa-shopping-cart"></i></button>
                    </div>
                    <a href="{{ route('product.details',$bestProduct->slug) }}"><i class="fa fa-search"></i></a> <a href="javascript:;"><i class="fa fa-heart"></i></a> </div>
                </div>
              </div>
            </div>
            @endforeach
     
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- category-area end -->
  @endif 
  
  
  <div class="container" wire:ignore>
    <div id="latest-news" class="news">
      <div class="page-header">
        <h2>Latest news</h2>
      </div>
      <div class="slider-items-products">
        <div id="latest-news-slider" class="product-flexslider hidden-buttons">
          <div class="slider-items slider-width-col6"> 
          @foreach($blog_posts as $blogPost)
            <!-- Item -->
            <div class="item">
              <div class="jtv-single-blog">
                <div class="blog-image"> <a href="{{ route('blog.details',$blogPost->id) }}"> <img src="{{ asset('assets/images/blogs/'.$blogPost->photo) }}" alt="Blog"> </a> <span class="blog-date"> <a href="index.html#"> <span class="month-date"><small>{{ Carbon\Carbon::parse($blogPost->created_at)->format('d') }}</small>{{ Carbon\Carbon::parse($blogPost->created_at)->format('M') }}</span> </a> </span> </div>
                <div class="blog-content">
                  <div class="title-desc"> <a href="{{ route('blog.details',$blogPost->id) }}">
                    <h4>{{mb_strlen($blogPost->title,'utf-8') > 45 ? mb_substr($blogPost->title,0,45,'utf-8')." .." : $blogPost->title}}</h4>
                    </a>
                    <p>
                      {{ $blogPost->short_description }}
                    </p>
                  </div>
                  <div class="blog-info"> <span class="author-name"> <i class="fa fa-user"></i>By <a href="index.html#">{{ $blogPost->getAuthor->name }}</a> </span> 
                    <span class="comments-number"> <i class="fa fa-comment"></i>{{ $blogPost->getComments->count()}} Comment </span> </div>
                </div>
              </div>
            </div>
            <!-- End Item --> 
            @endforeach
            
            <!-- End Item --> 
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <livewire:front.components.dispatcher/>
</div>
