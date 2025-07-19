<!DOCTYPE html>
<html lang="en">
<head>
<!-- Basic page needs -->
<meta charset="utf-8">
<!--[if IE]>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <![endif]-->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>{{ $gs->title }}</title>
<meta name="description" content="">

<!-- Mobile specific metas  -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Favicon  -->
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

<!-- CSS Style -->
<link rel="stylesheet" href="{{ asset('front/theme/style.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body class="cms-index-index cms-home-page">

<!--[if lt IE 8]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]--> 

<!-- mobile menu -->
<div id="mobile-menu">
  <div id="mobile-search">
    <form>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" name="search">
        <button class="btn-search" type="button"><i class="fa fa-search"></i></button>
      </div>
    </form>
  </div>
  <ul>
    <div class="menu-container" style="display:flex;">
      <li id="menus" class="active"><a class="cursor-pointer" id="menu">Menu</a></li>
      <li id="cats"><a class="cursor-pointer" id="category">Categories</a></li>
    </div>
    
    <div id="menu-items">
      <li>
        <a href="{{ route('front.index') }}">Acasa</a>
    </li>
    @foreach($mainMenus->menuItems as $mobileMain)
      <li><a @if($mobileMain->submenuItems->count() > 0) href="javascript:;" @else href="{{ route('front.menu',$mobileMain->itemParentPage->slug) }} @endif ">{{ $mobileMain->itemParentPage->title }}</a>
    @if($mobileMain->submenuItems->count() > 0)
        <ul>
          @foreach($mobileMain->submenuItems as $mobileSub)
          <li> <a @if($mobileSub->childMenuItems->count() > 0) href="javascript:;" @else href="{{ route('front.menu',$mobileSub->page->slug) }}" @endif >{{ $mobileSub->page->title }}</a>
          @if($mobileSub->childMenuItems->count() > 0)
            <ul>
          @foreach($mobileSub->childMenuItems as $mobileChild)
              <li><a href="{{ route('front.menu',$mobileChild->childParentPage->slug) }}">{{ $mobileChild->childParentPage->title }} </a> </li>
          @endforeach
            
            </ul>
          @endif 
          </li>
        @endforeach
        
        </ul>
    @endif 
      </li>
    @endforeach
    </div>
    <div id="category-items" style="display: none;">
     @foreach($categories as $mobileCategory)
     <li><a  @if($mobileCategory->subs()->whereStatus(1)->count() > 0) href="javascript:;" @else href="{{ route('explore.shop',['type'=>'category','slug'=>$mobileCategory->slug]) }}" @endif >{{ $mobileCategory->name }}</a>
     @if($mobileCategory->subs()->whereStatus(1)->count() > 0)
      <ul>
      @foreach($mobileCategory->subs()->whereStatus(1)->get() as $mobileSubCategory)
        <li><a @if($mobileSubCategory->childs()->whereStatus(1)->count() > 0) href="javascript:;" @else href="{{ route('explore.shop',['type'=>'subcategory','slug'=>$mobileSubCategory->slug]) }}" @endif  class="">{{ $mobileSubCategory->name }}</a>
        @if($mobileSubCategory->childs()->whereStatus(1)->count() > 0)
          <ul>
          @foreach($mobileSubCategory->childs()->whereStatus(1)->get() as $mobileChildCategory)
            <li><a href="{{ route('explore.shop',['type'=>'childcategory','slug'=>$mobileChildCategory->slug]) }}">{{ $mobileChildCategory->name }}</a></li>
          @endforeach
          
          </ul>
        @endif 
        </li>
      @endforeach
       
      </ul>
    @endif
    </li>
     @endforeach
     
     
    </div>

   
    
  </ul>
</div>
<!-- end mobile menu -->
<div id="page"> 
  
  <!-- Header -->
  <header>
    <div class="header-container">
      <div class="header-top">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-sm-4 hidden-xs"> 
              <!-- Default Welcome Message -->
              <div class="welcome-msg ">{{ $langg->lang431 }} </div>
            </div>
            
            <!-- top links -->
            <div class="headerlinkmenu col-lg-8 col-md-7 col-sm-8 col-xs-12">
              <div class="links">
                <div class="myaccount"><a title="My Account" href="account_page.html"><i class="fa fa-user"></i><span class="hidden-xs">My Account</span></a></div>
                <div class="wishlist"><a title="My Wishlist" href="wishlist.html"><i class="fa fa-heart"></i><span class="hidden-xs">Wishlist</span></a></div>
                <div class="blog"><a title="Blog" href="{{ route('front.contact') }}"><i class="fa fa-envelope"></i><span class="hidden-xs">Contact</span></a></div>
                @if(Auth::guard('web')->check())
                <div class="login"><a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-unlock-alt"></i><span class="hidden-xs">Log Out</span></a></div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                @else  
                <div class="login"><a href="{{ route('user.login') }}"><i class="fa fa-unlock-alt"></i><span class="hidden-xs">Log In</span></a></div>
                @endif 
              </div>
              <div class="language-currency-wrapper">
                <div class="inner-cl">
                @if($gs->is_language == 1)
                  <div class="block block-language form-language">
                    <div class="lg-cur"> <span>  <span class="lg-fr">{{ $language->language }}</span>
                         <i class="fa fa-angle-down"></i> </span> </div>
                    <ul>
                    @foreach(DB::table('languages')->where('id','!=',$language->id)->get() as $lang)
                      <li> <a class="selected" href="{{ route('front.language',$lang->id) }}"> <img src="{{ asset('assets/languages/flags/'.$lang->flag) }}" alt="flag" height="16" width="16"> <span>{{ $lang->language }}</span> </a> </li>
                      @endforeach
                    
                    </ul>
                  </div>
                @endif 
                @if($gs->is_currency == 1)  
                
                  <div class="block block-currency">
                    <div class="item-cur"> <span class="curr_icon">{{ $current_currency->sign ?? '-' }}</span> {{ $current_currency->name }}<i class="fa fa-angle-down"></i></div>
                    <ul>
                    @foreach(DB::table('currencies')->where('id','!=',$current_currency->id)->get() as $currency)
                      <li> <a href="{{ route('front.currency',$currency->id) }}"><span class="cur_icon">{{ $currency->sign ?? '-' }}</span> {{ $currency->name }}</a> </li>
                    @endforeach
                     
                    </ul>
                  </div>
                @endif
                </div>
                
                <!-- End Default Welcome Message --> 
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container header-mid">
        <div class="row">
          <div class="col-sm-4 col-md-3 col-xs-8"> 
            <!-- Header Logo -->
            <div class="logo"><a title="e-commerce" href="{{ route('front.index') }}"><img alt="e-commerce" src="{{ asset('assets/images/'.$gs->logo) }}"></a> </div>
            <!-- End Header Logo --> 
          </div>
          <div class="col-md-9 col-sm-8 col-xs-4">
            <div class="mtmegamenu">
              <ul class="hidden-xs">
                <li class="mt-root">
                  <div class="mt-root-item"><a href="shop_grid.html">
                    <div class="title title_font"><span class="title-text">Acasa</span> </div>
                    </a></div>
                </li>
              @foreach($mainMenus->menuItems as $mainMenu)
              @if($mainMenu->submenuItems->count()==0)
                <li class="mt-root">
                  <div class="mt-root-item"><a href="{{ route('front.menu',$mainMenu->itemParentPage->slug) }}">
                    <div class="title title_font"><span class="title-text">{{ $mainMenu->itemParentPage->title }}</span> </div>
                    </a></div>
                </li>
              @endif     
              @if($mainMenu->submenuItems->count() > 0)
                <li class="mt-root demo_custom_link_cms">
                  <div class="mt-root-item">
                      <a href="javascript:;">
                          <div class="title title_font"><span class="title-text">{{ $mainMenu->itemParentPage->title }} </span> <i class="fa fa-angle-down" style="color:black;"></i> </div>
                      </a>
                  </div>
                  <ul class="menu-items col-md-3 col-sm-4 col-xs-12">
                  @foreach($mainMenu->submenuItems as $subMenu)
                      <li class="menu-item depth-1">
                          <div class="title">
                              <a  @if($subMenu->childMenuItems->count() > 0) href="javascript:;" @else href="{{ route('front.menu',$subMenu->page->slug) }}" @endif >{{ $subMenu->page->title }} @if($subMenu->childMenuItems->count() > 0) <i class="fa fa-angle-right pull-right"></i> @endif </a>
                          </div>
                  @if($subMenu->childMenuItems->count() > 0)
                          <ul class="submenu">
                      @foreach($subMenu->childMenuItems as $childMenu)
                              <li class="menu-item">
                                  <a href="{{ route('front.menu',$childMenu->childParentPage->slug) }}">{{ $childMenu->childParentPage->title }}</a>
                              </li>
                      @endforeach
                          </ul>
                  @endif 
                      </li>
                    @endforeach
                     
                  </ul>
              </li>
              @endif 
              @endforeach
            
              </ul>
              <!-- top cart -->
              <div class="col-md-3 col-xs-9 col-sm-2 top-cart">
                <div class="top-cart-contain">
                    <livewire:front.components.mini-cart />
                </div>
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- end header --> 
  
  <!-- Navbar -->
  <nav>
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-3">
          <div class="mm-toggle-wrap">
            <div class="mm-toggle"> <i class="fa fa-align-justify"></i> </div>
            <span class="mm-label hidden-xs">Categories</span> </div>
          <div class="mega-container visible-lg visible-md visible-sm">
            <div class="navleft-container">
              <div class="mega-menu-title">
                <h3>{{ $langg->lang1 }}</h3>
              </div>
              <div class="mega-menu-category">
                <ul class="nav">
                @foreach($categories as $mainCategory)
                @if($mainCategory->category_type=='mega')
                  <li> <a href="javascript:;"><img src="{{ asset('assets/images/categories/'.$mainCategory->photo) }}"
                    style="min-height:20px;max-height:20px;min-width:20px;max-width:20px;" /> {{ $mainCategory->name }} <div class="i fa fa-angle-right pull-right"></div></a>
                    <div class="wrap-popup">
                      <div class="popup">
                        <div class="row">
                        @foreach($mainCategory->subs()->whereStatus(1)->get() as $subCategory)
                          <div class="col-md-4 col-sm-3">
                           
                            <h3>{{ $subCategory->name }}</h3>
                            <hr>
                            <ul class="nav">
                            @foreach($subCategory->childs()->whereStatus(1)->get() as $childCategory)
                              <li><a href="{{ route('explore.shop',['childcategory',$childCategory->slug]) }}">{{ $childCategory->name }}</a></li>
                            @endforeach
                             
                            </ul>
                            <br>
                          
                          </div>
                         
                        @endforeach
                        </div>
                      </div>
                    </div>
                  </li>
                  @endif 
                     
                  
                @if($mainCategory->category_type=='has_childs')
                  
                  <li>
                    <a href="javascript:;"><img src="{{ asset('assets/images/categories/'.$mainCategory->photo) }}" 
                      style="min-height:16px;max-height:16px;min-width:16px;max-width:16px;"/> {{ $mainCategory->name }} <i class="fa fa-angle-right pull-right"></i></a>
                    <div class="wrap-popup column1">
                      <div class="popup has-subpopup">
                        <ul class="nav">
                      @foreach($mainCategory->subs()->whereStatus(1)->get() as $subCategory)
                          <li>
                            <a @if($subCategory->childs()->whereStatus(1)->count() > 0) href="javascript:;" @else href="{{ route('explore.shop',['subcategory',$subCategory->slug]) }}" @endif class="has-child"><span>{{ $subCategory->name }} @if($subCategory->childs()->whereStatus(1)->count() > 0) <i class="fa fa-angle-right"></i> @endif </span></a>
                          @if($subCategory->childs()->whereStatus(1)->count() > 0)
                            <ul class="child-menu">
                            @foreach($subCategory->childs()->whereStatus(1)->get() as $childCategory)
                              <li>
                                <a href="{{ route('explore.shop',['childcategory',$childCategory->slug]) }}"><span>{{ $childCategory->name }}</span></a>
                              </li>
                            @endforeach
                             
                            </ul>
                          @endif 
                          </li>
                          @endforeach
                        
                        </ul>
                      </div>
                    </div>
                  </li>
                  @endif 

                  @if($mainCategory->category_type=='single')
                  <li class="nosub"><a href="{{ route('explore.shop',['category',$mainCategory->slug]) }}"><img src="{{ asset('assets/images/categories/'.$mainCategory->photo) }}" 
                    style="min-height:16px;max-height:16px;min-width:16px;max-width:16px;"/> {{ $mainCategory->name }}</a></li>
                  @endif 
                  @if($loop->index == 14)
                  <li class="nosub"><a href="javascript:;"><i class="icon fa fa-shopping-basket fa-fw"></i>All Categories</a></li>
                  @endif 
                @endforeach
                
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-9 col-sm-6 col-md-6 hidden-xs"> 
          <!-- Search -->
          
         <livewire:front.components.top-search />
          
          <!-- End Search --> 
        </div>
        <div class="call-us hidden-sm hidden-xs"> 
          <a href="tel:#"></a>
          <i class="fa fa-phone"></i>
          <div class="call-us-inner"> <span class="call-text">free call us</span> <span class="call-num">Call: + 0123 456 789</span> </div>
         </a>
        </div>
      </div>
    </div>
  </nav>
  <!-- end nav --> 
  
  <!-- Home Slider Start -->
  
  {{ $slot }}


  
  <!-- Footer -->
  
  <footer wire:ignore> 
    
    <!-- our clients Slider -->
    <div class="our-clients" wire:ignore>
      <div class="container">
        <div class="col-md-12">
          <div class="slider-items-products">
            <div id="our-clients-slider" class="product-flexslider hidden-buttons">
              <div class="slider-items slider-width-col6"> 
              @foreach($partnersSection as $partner)
             
                <!-- Item -->
                <div class="item"> <a href="{{ $partner->link }}"><img src="{{asset('assets/images/partner/'.$partner->photo)}}" alt=""></a> </div>
                <!-- End Item --> 
              @endforeach
               
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-3 col-xs-12 col-lg-2 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Information<a class="expander visible-xs" href="index.html#TabBlock-1">+</a></h3>
            <div class="tabBlock" id="TabBlock-1">
              <ul class="list-links list-unstyled">
                <li><a href="index.html#s">Delivery Information</a></li>
                <li><a href="index.html#">Discount</a></li>
                <li><a href="sitemap.html">Sitemap</a></li>
                <li><a href="index.html#">Privacy Policy</a></li>
                <li><a href="faq.html">FAQs</a></li>
                <li><a href="index.html#">Terms &amp; Condition</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xs-12 col-lg-2 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Insider<a class="expander visible-xs" href="index.html#TabBlock-3">+</a></h3>
            <div class="tabBlock" id="TabBlock-3">
              <ul class="list-links list-unstyled">
                <li> <a href="sitemap.html">Sites Map </a> </li>
                <li> <a href="index.html#">News</a> </li>
                <li> <a href="index.html#">Trends</a> </li>
                <li> <a href="about_us.html">About Us</a> </li>
                <li> <a href="contact_us.html">Contact Us</a> </li>
                <li> <a href="index.html#">My Orders</a> </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-2 col-xs-12 col-lg-2 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Service<a class="expander visible-xs" href="index.html#TabBlock-4">+</a></h3>
            <div class="tabBlock" id="TabBlock-4">
              <ul class="list-links list-unstyled">
                <li> <a href="account_page.html">Account</a> </li>
                <li> <a href="wishlist.html">Wishlist</a> </li>
                <li> <a href="shopping_cart.html">Shopping Cart</a> </li>
                <li> <a href="index.html#">Return Policy</a> </li>
                <li> <a href="index.html#">Special</a> </li>
                <li> <a href="index.html#">Lookbook</a> </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xs-12 col-lg-3">
          <h3 class="links-title">Contact us</h3>
          <p>Lorem Ipsum is simply dummy text of the print and typesetting industry.</p>
          <div class="footer-content">
            <div class="email"> <i class="fa fa-envelope"></i>
              <p><a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d685a3a6a6b9a4a296a2beb3bbb3a5f8b5b9bb">[email&#160;protected]</a></p>
            </div>
            <div class="phone"> <i class="fa fa-phone"></i>
              <p>(800) 0123 456 789</p>
            </div>
            <div class="address"> <i class="fa fa-map-marker"></i>
              <p> My Company, 12/34 - West 21st Street, New York, USA</p>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-xs-12 col-lg-3">
          <div class="footer-links">
            <div class="footer-newsletter">
              <h3 class="links-title">Sign up for newsletter</h3>
              <form id="newsletter-validate-detail" method="post" action="index.html#">
                <div class="newsletter-inner">
                  <input class="newsletter-email" name='Email' placeholder='Enter Your Email'/>
                  <button class="button subscribe" type="submit" title="Subscribe">Subscribe</button>
                </div>
              </form>
            </div>
            <div class="social">
              <ul class="inline-mode">
                <li class="social-network fb"><a title="Connect us on Facebook" target="_blank" href="https://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
                <li class="social-network googleplus"><a title="Connect us on Google+" target="_blank" href="https://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
                <li class="social-network tw"><a title="Connect us on Twitter" target="_blank" href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                <li class="social-network linkedin"><a title="Connect us on Linkedin" target="_blank" href="https://www.pinterest.com/"><i class="fa fa-linkedin"></i></a></li>
                <li class="social-network rss"><a title="Connect us on Instagram" target="_blank" href="https://instagram.com/"><i class="fa fa-rss"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-coppyright">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-xs-12 coppyright"> Copyright © 2016-2022 <a href="index.html#"> Smart </a>. All Rights Reserved. </div>
          <div class="col-sm-6 col-xs-12">
            <div class="payment">
              <ul>
                <li><a href="index.html#"><img title="Visa" alt="Visa" src="{{ asset('front/theme/images/visa.png') }}"></a></li>
                <li><a href="index.html#"><img title="Paypal" alt="Paypal" src="{{ asset('front/theme/images/paypal.png') }}"></a></li>
                <li><a href="index.html#"><img title="Discover" alt="Discover" src="{{ asset('front/theme/images/discover.png') }}"></a></li>
                <li><a href="index.html#"><img title="Master Card" alt="Master Card" src="{{ asset('front/theme/images/master-card.png') }}"></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <a href="index.html#" class="totop"><i class="fa fa-arrow-up"></i></a> 
  <!-- End Footer --> 
  <livewire:front.components.newsletter />
  
</div>

<!-- JS --> 

<!-- jquery js --> 
<script data-cfasync="false" src="{{ asset('front/theme/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('front/theme/js/jquery.min.js') }}"></script> 

<!-- bootstrap js --> 
<script type="text/javascript" src="{{ asset('front/theme/js/bootstrap.min.js') }}"></script> 

<!-- Slider Js --> 
<script type="text/javascript" src="{{ asset('front/theme/js/revolution-slider.js') }}"></script> 

<!-- owl.carousel.min js --> 
<script type="text/javascript" src="{{ asset('front/theme/js/owl.carousel.min.js') }}"></script> 

<!-- bxslider js --> 
<script type="text/javascript" src="{{ asset('front/theme/js/jquery.bxslider.js') }}"></script> 

<!-- megamenu js --> 
<script type="text/javascript" src="{{ asset('front/theme/js/megamenu.js') }}"></script> 
<script type="text/javascript">
  /* <![CDATA[ */   
  var mega_menu = '0';
  /* ]]> */
</script> 

<!-- jquery.mobile-menu js --> 
<script type="text/javascript" src="{{ asset('front/theme/js/mobile-menu.js') }}"></script> 

<!--jquery-ui.min js --> 
<script type="text/javascript" src="{{ asset('front/theme/js/jquery-ui.js') }}"></script> 

<!-- main js --> 
<script type="text/javascript" src="{{ asset('front/theme/js/main.js') }}"></script> 

<!-- countdown js --> 
<script type="text/javascript" src="{{ asset('front/theme/js/countdown.js') }}"></script> 

<script type="text/javascript" src="{{ asset('front/theme/js/cloud-zoom.js') }}"></script>

<script type="text/javascript" src="js/bootstrap.min.js"></script> 

<!-- owl.carousel.min js --> 



<!-- flexslider js --> 
<script type="text/javascript" src="{{ asset('front/theme/js/jquery.flexslider.js') }}"></script> 
<script type="text/javascript" src="{{ asset('front/theme/js/stripe.js') }}"></script>
<!-- megamenu js --> 

<script type="text/javascript">
  /* <![CDATA[ */   
  var mega_menu = '0';
  
  /* ]]> */
  </script> 
 
<script type="text/javascript">
			var setREVStartSize=function(){};
						
				
			setREVStartSize();
			function revslider_showDoubleJqueryError(sliderID) {}
			var tpj=jQuery;
			tpj.noConflict();
			var revapi6;
			tpj(document).ready(function() {
				if(tpj("#rev_slider_6_1").revolution == undefined){
					revslider_showDoubleJqueryError("#rev_slider_6_1");
				}else{
					revapi6 = tpj("#rev_slider_6_1").show().revolution({
						sliderType:"standard",
						sliderLayout:"auto",
						dottedOverlay:"none",
						delay:6000,
						navigation: {
							keyboardNavigation:"off",
							keyboard_direction: "horizontal",
							mouseScrollNavigation:"off",
							onHoverStop:"off",
							touch:{
								touchenabled:"on",
								swipe_threshold: 0.7,
								swipe_min_touches: 1,
								swipe_direction: "horizontal",
								drag_block_vertical: false
							}
							,
							arrows: {
								style:"hades",
								enable:true,
								hide_onmobile:false,
								hide_onleave:true,
								hide_delay:200,
								hide_delay_mobile:1200,
								tmp:'<div class="tp-arr-allwrapper">	<div class="tp-arr-imgholder"></div></div>',
								left: {
									h_align:"left",
									v_align:"center",
									h_offset:20,
									v_offset:0
								},
								right: {
									h_align:"right",
									v_align:"center",
									h_offset:20,
									v_offset:0
								}
							}
							,
							bullets: {
								enable:true,
								hide_onmobile:false,
								style:"hades",
								hide_onleave:true,
								hide_delay:200,
								hide_delay_mobile:1200,
								direction:"horizontal",
								h_align:"center",
								v_align:"bottom",
								h_offset:0,
								v_offset:20,
								space:5,
								tmp:'<span class="tp-bullet-image"></span>'
							}
						},
						gridwidth:1920,
						gridheight:650,
						lazyType:"none",
						shadow:0,
						spinner:"spinner0",
						stopLoop:"off",
						stopAfterLoops:-1,
						stopAtSlide:-1,
						shuffle:"off",
						autoHeight:"on",
						disableProgressBar:"on",
						hideThumbsOnMobile:"off",
						hideSliderAtLimit:0,
						hideCaptionAtLimit:0,
						hideAllCaptionAtLilmit:0,
						startWithSlide:0,
						debugMode:false,
						fallbacks: {
							simplifyAll:"off",
							nextSlideOnWindowFocus:"off",
							disableFocusListener:false,
						}
					});
				}
			});	/*ready*/
		</script>
    <script type="text/javascript" src="https://htmlsmart.justthemevalley.com/version2/js/slider.js"></script> 


    @stack('js')

    
</body>
    


</html>

