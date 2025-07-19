<div>
    
  
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a title="Go to Home Page" href="index.html">Home</a><span>&raquo;</span></li>
           
            <li><strong>Checkout</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumbs End --> 
  
<!-- Main Container -->
<section class="main-container col2-right-layout" x-data="{
    billingAddressOpen:@entangle('billingAddressOpen'),
    shippingAddressOpen:@entangle('shippingAddressOpen'),
    shippingMethodOpen:@entangle('shippingMethodOpen'),
    paymentMethodOpen:@entangle('paymentMethodOpen'),
    companyFormOpen:@entangle('companyFormOpen'),
    orderReviewOpen:@entangle('orderReviewOpen'),
}">
  <div class="main container">
    <div class="row">
      <div class="col-main col-sm-9 col-xs-12">
 
        
        <div class="page-content checkout-page"><div class="page-title">
          <h2>Checkout</h2>
        </div>
            <h4 class="checkout-sep">1. Checkout Method</h4>
            @if(!Auth::guard('web')->check())
            <div class="box-border">
                <div class="row">
                    <div class="col-sm-6 col-md-12" x-data="{
                        showLoginForm:false,
                    }">
                        <h5 @click="showLoginForm = !showLoginForm">Login <span class="pull-right"><i class="fa fa-angle-down" x-show="!showLoginForm" x-cloak></i><i class="fa fa-angle-up" x-show="showLoginForm" x-cloak></i></span></h5>
                        <p>Already registered? Please log in below:</p>
                        <div class="login-form box-border" x-show="showLoginForm" x-cloak>
                            <label>Email address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input">
                            <label>Password</label>
                            <input type="password" class="form-control input">
                            <p><a href="checkout.html#">Forgot your password?</a></p>
                            <button class="button"><i class="icon-login"></i>&nbsp; <span>Login</span></button>
                        </div>
                    </div>
                    <hr>
                    <div class="col-sm-6 col-md-12" x-data="{registerFormOpen:false}">
                        <h5>Checkout as a Guest or Register</h5>
                        <p>Register with us for future convenience:</p>
                        <ul>
                            <li><label><input type="radio" name="radio1" checked @click="registerFormOpen=false,billingAddressOpen=true">Checkout as Guest</label></li>
                            <li><label><input type="radio" name="radio1" @click="registerFormOpen = !registerFormOpen,billingAddressOpen=true">Register</label></li>
                        </ul>
                        <div class="box-border" x-show="registerFormOpen" x-cloak style="border:solid gray 2px; padding:10px;">
                            <h3 class="text-center">Your Details</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="first_name" class="required">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="input form-control" name=""wire:model="fullName">
                                    @error('fullName') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email_address" class="required">Email Address <span class="text-danger">*</span></label>
                                    <input type="text" class="input form-control" name="" wire:model="emailAddress">
                                    @error('emailAddress') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="company_name">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="input form-control" name="" wire:model="phoneNumber">
                                    @error('phoneNumber') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="company_name">Profile Image</label>
                                    <input type="file" class="input form-control" name="" wire:model.live="profilePhoto">
                                    <div class="photo">
                                        <img src="{{ asset($dirPath.$getProfilePhoto) }}" alt="" height="100" style="border-radius:50%;">
                                    </div>
                                    @error('profilePhoto') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="required">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="input form-control" name="" wire:model="password">
                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="confirm" class="required">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="input form-control" name="" wire:model="password_confirmation">
                                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <button class="button" wire:click="registerUser"><i class="icon-login"></i>&nbsp; <span>Register</span></button>
                        </div>
                        <br>
                        <h4>Register and save time!</h4>
                        <p>Register with us for future convenience:</p>
                        <p><i class="fa fa-check-circle text-primary"></i> Fast and easy check out</p>
                        <p><i class="fa fa-check-circle text-primary"></i> Easy access to your order history and status</p>
                     
                    </div>
                

                </div>
            </div>
            @endif 
            <h4 class="checkout-sep" @click="billingAddressOpen=!billingAddressOpen">2. Billing Infomations <span class="pull-right"><i class="fa fa-angle-down" x-show="!billingAddressOpen" x-clak></i><i class="fa fa-angle-up"x-show="billingAddressOpen" x-cloak></i></span></h4>
            <div class="box-border" x-show="billingAddressOpen" x-cloak>
                <ul>
                    <li class="row">
                        <div class="col-sm-6">
                            <label for="first_name" class="required">First Name</label>
                            <input type="text" class="input form-control" name="" wire:model="billingName">
                            @error('billingName') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                        <div class="col-sm-6">
                            <label for="last_name" class="required">Last Name</label>
                            <input type="text" name="" class="input form-control" wire:model="billingLastName">
                            @error('billingLastName') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                    </li><!--/ .row -->
                    <li class="row">
                        <div class="col-sm-6">
                            <label for="company_name">Email Address</label>
                            <input type="text" name="" class="input form-control" wire:model="billingEmail">
                            @error('billingEmail') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                        <div class="col-sm-6">
                            <label for="email_address" class="required">Phone Number</label>
                            <input type="text" class="input form-control" name="" wire:model="billingPhone">
                            @error('billingPhone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                    </li><!--/ .row -->
                    <li class="row"> 
                        <div class="col-xs-12">

                            <label for="address" class="required">Billing Address</label>
                            <input type="text" class="input form-control" name="" wire:model="billingAddress">
                            @error('billingAddress') <span class="text-danger">{{ $message }}</span> @enderror

                        </div><!--/ [col] -->

                    </li><!-- / .row -->

                    <li class="row">

                        <div class="col-sm-6">
                            
                            <label for="city" class="required">Billing City</label>
                            <input class="input form-control" type="text" name="" wire:model="billingCity">

                        </div><!--/ [col] -->

                        <div class="col-sm-6">
                            <label class="required">Billing State</label>
                                <select class="input form-control" name="" wire:model="billingState">
                                @if(count($getStates)>0)
                                @foreach($getStates as $state)
                                    <option value="{{ $state->country_name }}" {{ $billingState==$state->country_name ? 'selected' : '' }}>{{ $state->country_name }}</option>
                                @endforeach
                                
                                @else      
                                    <option value="{{ $billingState }}" selected>{{ $billingState }}</option>
                                @endif 
                                   
                            </select>
                            @error('billingState') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                    </li><!--/ .row -->

                    <li class="row">

                        <div class="col-sm-6">

                            <label for="postal_code" class="required">Zip/Postal Code</label>
                            <input class="input form-control" type="text" name="" wire:model="billingZip">
                            @error('billingZip') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->

                        <div  class="col-sm-6">
                            <label class="required">Province</label>
                            <input class="input form-control" type="text" name="" wire:model="billingProvince">
                            @error('billingProvince') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                        <div class="col-md-12"></div>
                        <div class="col-sm-6">
                            <label for="personalInfo"><input type="radio" name="identifyPerson" wire:model="identifyPerson" value="physicalPerson" wire:click="changePerson('physicalPerson')" id="">I am a person</label>
                        </div>
                        <div class="col-sm-6">
                            <label for="personalInfo"><input type="radio" name="identifyPerson" wire:model="identifyPerson" value="isCompany"  wire:click="changePerson('isCompany')" id="">I am Company</label>
                        </div>
                    </li><!--/ .row -->
                    
                    <hr>
                    <h4 class="company" @click="companyFormOpen=!companyFormOpen">Company Details <span class="pull-right"><i class="fa fa-angle-down" x-show="!companyFormOpen" x-cloak></i><i class="fa fa-angle-up" x-show="companyFormOpen" x-cloak></i></span></h4>
                    <li class="row" x-show="companyFormOpen" x-cloak>
                        <div class="col-sm-6">
                            <label for="password" class="required">Fiscal Code</label>
                            <input class="input form-control" type="text" name="" wire:model="companyFiscal">
                            @error('companyFiscal') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->

                        <div class="col-sm-6">
                            <label for="confirm" class="required">Registration Number</label>
                            <input class="input form-control" type="text" name="" wire:model="companyIdentification">
                            @error('companyIdentification') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                        <div class="col-sm-6">
                            <label for="password" class="required">Company Name</label>
                            <input class="input form-control" type="text" name="" wire:model="companyName">
                            @error('companyName') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->

                        <div class="col-sm-6">
                            <label for="confirm" class="required">Contact Person</label>
                            <input class="input form-control" type="text" name="" wire:model="companyContact">
                            @error('companyContact') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->

                        <div class="col-sm-6">
                            <label for="password" class="required">Contact Email</label>
                            <input class="input form-control" type="text" name="" wire:model="companyEmail">
                            @error('companyEmail') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->

                        <div class="col-sm-6">
                            <label for="confirm" class="required">Contact Phone </label>
                            <input class="input form-control" type="text" name="" wire:model="companyPhone">
                            @error('companyPhone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                        <div class="col-sm-12">
                            <label for="password" class="required">Company Address</label>
                            <input class="input form-control" type="text" name="" wire:model="companyAddress">
                            @error('companyAddress') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->

                        <div class="col-sm-6">
                            <label for="confirm" class="required">Company City</label>
                            <input class="input form-control" type="text" name="" wire:model="companyCity">
                            @error('companyCity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->

                        <div class="col-sm-6">
                            <label class="required">Company  State</label>
                            <select class="input form-control" name="" wire:model="companyState">
                                @if(count($getStates)>0)
                                @foreach($getStates as $state)
                                    <option value="{{ $state->country_name }}" {{ $companyState==$state->country_name ? 'selected' : '' }}>{{ $companyState }}</option>
                                @endforeach
                                
                                @else      
                                    <option value="{{ $companyState }}" selected>{{ $companyState }}</option>
                                @endif 
                                   
                            </select>
                            @error('companyState') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                        <div class="col-sm-12">
                            <label for="password" class="required">Company Zip</label>
                            <input class="input form-control" type="text" name="" wire:model="companyZip">
                            @error('companyZip') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                        <div class="col-sm-12">
                            <label for="password" class="required">Administrator Name</label>
                            <input class="input form-control" type="text" name="" wire:model="administratorName">
                            @error('administratorName') <span class="text-danger">{{ $message }}</span> @enderror
                        </div><!--/ [col] -->
                        <div class="col-sm-12">
                    
                            <input  type="checkbox" {{ $taxPayment ? 'checked' : '' }} name="" wire:model="taxPayment" id="taxes">
                            <label for="taxes" class="required">Include Taxes</label>
                            @error('taxPayment') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                     
                        <div class="col-sm-12">                    
                            <input  type="checkbox" {{ $sendInfo ? 'checked' : '' }} name="" wire:model="sendInfo" id="sendInfo">
                            <label for="sendInfo" class="required">Ship to Company</label>
                            @error('taxPayment') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                      
                    </li><!--/ .row -->
                    <li>
                        <button class="button" wire:click="nextStep('billingAddress')"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Continue</span></button>
                    </li>
                    <hr>
                </ul>
            </div>
            <h4 class="checkout-sep" @if(session()->has('billingAddress')) @click="shippingAddressOpen = !shippingAddressOpen" @endif >3. Shipping Information @if(session()->has('billingAddress'))<span class="pull-right"><i class="fa fa-angle-down" x-show="!shippingAddressOpen" x-cloak></i><i class="fa fa-angle-up" x-show="shippingAddressOpen" x-cloak></i></span> @endif </h4>
            <div class="box-border" x-show="shippingAddressOpen" x-cloak>
                <ul>
                                    
                    <li class="row">
                        
                        <div class="col-sm-12">
                            
                            <label for="first_name_1" class="required">Receiver Name <span class="text-danger">*</span></label>
                            <input class="input form-control" type="text" name="" wire:model="receiverName">

                        </div><!--/ [col] -->

                       
                    </li><!--/ .row -->

                    <li class="row">
                        
                        <div class="col-sm-6">
                            
                            <label for="company_name_1">Email Address <span class="text-danger">*</span></label>
                            <input class="input form-control" type="text" name="" wire:model="shippingEmail">

                        </div><!--/ [col] -->

                        <div class="col-sm-6">
                            
                            <label for="email_address_1" class="required">Phone Number <span class="text-danger">*</span></label>
                            <input class="input form-control" type="text" name="" wire:model="shippingPhone">

                        </div><!--/ [col] -->

                    </li><!--/ .row -->

                    <li class="row">

                        <div class="col-xs-12">

                            <label for="address_1" class="required">Shipping Address <span class="text-danger">*</span></label>
                            <input class="input form-control" type="text" name="" wire:model="shippingAddress">

                        </div><!--/ [col] -->

                    </li><!--/ .row -->

                    <li class="row">

                        <div class="col-sm-6">
                            
                            <label for="city_1" class="required">Shipping City</label>
                            <input class="input form-control" type="text" name="" wire:model="shippingCity">

                        </div><!--/ [col] -->

                        <div class="col-sm-6">

                            <label class="required">Shipping State</label>

                            <div class="custom_select" >

                                <select class="input form-control" name="" wire:model="shippingState">
                                    @if(count($getStates)>0)
                                    @foreach($getStates as $state)
                                        <option value="{{ $state->country_name }}" {{ $shippingState==$state->country_name ? 'selected' : '' }}>{{ $shippingState }}</option>
                                    @endforeach
                                    
                                    @else      
                                        <option value="{{ $shippingState }}" selected>{{ $shippingState }}</option>
                                    @endif 
                                       
                                </select>
                            </div>

                        </div><!--/ [col] -->

                    </li><!--/ .row -->

                    <li class="row">

                        <div class="col-sm-6">

                            <label for="postal_code_1" class="required">Zip/Postal Code</label>
                            <input class="input form-control" type="text" name="" wire:model="shippingZip">

                        </div><!--/ [col] -->

                        <div class="col-sm-6">

                            <label class="required">Fax Number(Optional)</label>

                            <div class="custom_select">
                                <input type="text" class="form-control" wire:model="receiverFax">
                            </div>

                        </div><!--/ [col] -->

                    </li><!--/ .row -->

                    <li class="row">

                        <div class="col-sm-12">

                            <label for="telephone_1" class="required">Mentions(Optional)</label>
                           <textarea name="" class="form-control" id="" cols="30" rows="10" wire:model="shippingMentions"></textarea>

                        </div><!--/ [col] -->

                      

                    </li><!--/ .row -->

                </ul>
                <button class="button" wire:click="nextStep('shippingAddress')"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Continue</span></button>
            </div>
            <h4 class="checkout-sep" @if(session()->has('shippingAddress')) @click="shippingMethodOpen = !shippingMethodOpen" @endif >4. Shipping Method <span class="pull-right"><i class="fa fa-angle-down" x-show="!shippingMethodOpen" x-cloak></i> <i class="fa fa-angle-up" x-show="shippingMethodOpen" x-cloak></i></span></h4>
            <div class="box-border" x-show="shippingMethodOpen" x-cloak>
                <ul class="shipping_method">
                @foreach($shippingOptions as $shippingOption)
                    <li>
                        <p class="subcaption bold">{{ $shippingOption->title }}</p> 
                        <label for="radio_button_3"><input type="radio" wire:click="changeShippingMethod('{{ $shippingOption->id }}')"  wire:model="shippingMethodName" value="{{ $shippingOption->title }}" name="shipping_method_name">{{ $shippingOption->subtitle }} 
                            @php
                            $formatedOptionPrice = $shippingOption->price ? round($shippingOption->price*$current_currency->value,2) : '0.00';
                            $currencySymbol = $current_currency->sign ?? $current_currency->name; // Choose sign or name
                            @endphp
                    
                            @if($gs->currency_format)
                        
                                @if($current_currency->sign)
                                  
                                    {{ $formatedOptionPrice }} {{ $current_currency->sign }}
                                @else
                              
                                    {{ $formatedOptionPrice }} {{ $current_currency->name }}
                                @endif
                            @else
                    
                                @if($current_currency->sign)
                                
                                    {{ $current_currency->sign }} {{ $formatedOptionPrice }}
                                @else
                                    
                                    {{ $formatedOptionPrice }} {{ $current_currency->name }} 
                                @endif
                            @endif
                        </label>
                    </li>
                @endforeach
                   @error('shippingMethodName') <span class="text-danger">{{ $message }}</span> @enderror
                </ul>
                <button class="button" wire:click="nextStep('shippingMethod')"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Continue</span></button>
            </div>
            <h4 class="checkout-sep" @if(session()->has('shippingMethodName')) @click="paymentMethodOpen = !paymentMethodOpen" @endif >5. Payment Information
                <span class="pull-right">
                    <i class="fa fa-angle-down" x-show="!paymentMethodOpen" x-cloak></i> 
                    <i class="fa fa-angle-up" x-show="paymentMethodOpen" x-cloak></i>
                </span>
            </h4>
            <div class="box-border" x-show="paymentMethodOpen" x-cloak>
                <ul>
                    <li>
                        <label for="radio_button_5"><input type="radio" checked name="radio_4"  wire:click="changePaymentMethod('moneyOrder')" wire:model="paymentMethodName" value="moneyOrder" id="radio_button_5"> Check / Money order</label>
                    </li>
                    <li>
                        <label for="radio_button_5"><input type="radio" checked name="radio_4"   wire:click="changePaymentMethod('cacheOnDelivery')" wire:model="paymentMethodName" value="cacheOnDelivery" id="radio_button_5">Cache On Delivery (Physical Products)</label>
                    </li>
                    <li>
            
                        <label for="radio_button_6"><input type="radio" name="radio_4" wire:click="changePaymentMethod('creditCard')" wire:model="paymentMethodName" value="creditCard" id="radio_button_6"> Credit card (Stripe Gateway)</label>
                    </li>

                </ul>
                <button class="button" wire:click="nextStep('paymentMethod')"><i class="fa fa-angle-double-right"></i>&nbsp; <span>Continue</span></button>
            </div>
            <h4 class="checkout-sep last" @if(session()->has('shippingMethodName')) @click="orderReviewOpen=!orderReviewOpen" @endif >6. Order Review
            <span class="pull-right">
                <i class="fa fa-angle-down" x-show="!orderReviewOpen" x-cloak></i> 
                <i class="fa fa-angle-up" x-show="orderReviewOpen" x-cloak></i>
            </span>
            </h4>
            <div class="box-border" x-show="orderReviewOpen" x-cloak>
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
                            <th class="action"><i class="fa fa-trash-o"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($cartItems as $key=>$cartItem)
                    @php $product = \App\Models\Product::find($cartItem['product_id']); @endphp
                        <tr>
                            <td class="cart_product">
                                <a href="{{ route('product.details',$product->slug) }}"><img src="{{ asset('assets/images/products/'.$product->photo) }}" alt="Product"></a>
                            </td>
                            <td class="cart_description">
                                <p class="product-name"><a href="{{ route('product.details',$product->slug) }}">{{ $product->name }}</a></p>
                                @if(!empty($product->color))
                                <div class="colors" x-data="{productColorOpen:false}">
                                    <h6 class="color" @click="productColorOpen = !productColorOpen">Colors: <span class="pull-right"><i class="fa fa-angle-down"x-show="!productColorOpen" x-cloak></i> <i class="fa fa-angle-up" x-show="productColorOpen" x-cloak></i></span></h6>
                                <div class="show-clor" x-show="productColorOpen" x-cloak>
                               
                                @foreach($product->color as $key=>$color)
                                 <span style="background:{{ $color }};color:{{ $color }}">a</span>   
                                @endforeach
                                </div>
                                </div>
                                <hr>
                                @endif
                                @if(!empty($product->size))
                                <div class="product-sizes" x-data="{productSizeOpen:false}">
                                    <h6 class="size" @click="productSizeOpen = !productSizeOpen">Sizes: <span class="pull-right">
                                        <i class="fa fa-angle-down" x-show="!productSizeOpen" x-cloak></i> 
                                        <i class="fa fa-angle-up" x-show="productSizeOpen" x-cloak></span>   
                                    </span></h6>
                                <div class="show-product-size" x-show="productSizeOpen:false">
                                @foreach($product->size as $size)
                                <small><a href="javascript:;">{{ strtoupper($size) }}</a></small>
                                @endforeach
                                </div>
                                </div>
                                @endif 
                            </td>
                            <td class="cart_avail"><span class="label label-success">In stock</span></td>
                            <td class="price"><span>
                                @php
                            $formatedOptionPrice = $cartItem['original_price'] ? round($cartItem['original_price']*$current_currency->value,2) : '0.00';
                            $currencySymbol = $current_currency->sign ?? $current_currency->name; // Choose sign or name
                            @endphp
                    
                            @if($gs->currency_format)
                        
                                @if($current_currency->sign)
                                  
                                    {{ $formatedOptionPrice }} {{ $current_currency->sign }}
                                @else
                              
                                    {{ $formatedOptionPrice }} {{ $current_currency->name }}
                                @endif
                            @else
                    
                                @if($current_currency->sign)
                                
                                    {{ $current_currency->sign }} {{ $formatedOptionPrice }}
                                @else
                                    
                                    {{ $formatedOptionPrice }} {{ $current_currency->name }} 
                                @endif
                            @endif
                            </span></td>
                            <td class="qty">
                                <input class="form-control input-sm"                                  
                                   wire:change="updateQuantity('{{ $cartItem['cart_key'] }}', $event.target.value)"
                                   value="{{ $cartItem['quantity'] }}" 
                                   type="number" 
                                   min="1">
                            </td>
                            <td class="price">
                                <span>
                                    @php
                            if($productTotal)
                            {   
                                $formatedOptionPrice = $productTotal ? round($productTotal*$current_currency->value,2) : '0.00';
                            }else{
                                $formatedOptionPrice = $cartItem['original_price'] ? round(($cartItem['original_price']*$current_currency->value)*$cartItem['quantity'],2) : '0.00';
                            }
                            $currencySymbol = $current_currency->sign ?? $current_currency->name; // Choose sign or name
                            @endphp
                    
                            @if($gs->currency_format)
                        
                                @if($current_currency->sign)
                                  
                                    {{ $formatedOptionPrice }} {{ $current_currency->sign }}
                                @else
                              
                                    {{ $formatedOptionPrice }} {{ $current_currency->name }}
                                @endif
                            @else
                    
                                @if($current_currency->sign)
                                
                                    {{ $current_currency->sign }} {{ $formatedOptionPrice }}
                                @else
                                    
                                    {{ $formatedOptionPrice }} {{ $current_currency->name }} 
                                @endif
                            @endif
                                </span>
                            </td>
                            <td class="action">
                              
                                <a href="javascript:;" wire:click="removeItem('{{ $cartItem['cart_key'] }}')"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                      
                    </tbody>
                    <tfoot>
                    @if($taxPayment)
                        <tr>
                            <td colspan="2" rowspan="2"></td>
                            <td colspan="3">Total products (tax incl.)</td>
                            <td colspan="2">
                                @php
                            $formatedOptionPrice = $formatedTotal ? round($formatedTotal*$current_currency->value,2) : '0.00';
                            $currencySymbol = $current_currency->sign ?? $current_currency->name; // Choose sign or name
                            @endphp
                    
                            @if($gs->currency_format)
                        
                                @if($current_currency->sign)
                                  
                                    {{ $formatedOptionPrice }} {{ $current_currency->sign }}
                                @else
                              
                                    {{ $formatedOptionPrice }} {{ $current_currency->name }}
                                @endif
                            @else
                    
                                @if($current_currency->sign)
                                
                                    {{ $current_currency->sign }} {{ $formatedOptionPrice }}
                                @else
                                    
                                    {{ $formatedOptionPrice }} {{ $current_currency->name }} 
                                @endif
                            @endif    
                            </td>
                        </tr>
                    
                    @else       
                    <tr>
                        <td colspan="2" rowspan="2"></td>
                        <td colspan="3">Total products (tax incl.)</td>
                        <td colspan="2">
                            No taxes
                        </td>
                    </tr>

                    @endif
                        <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td colspan="2"><strong>
                            @php
                                $formatedOptionPrice = $formatedTotal ? round($formatedTotal*$current_currency->value,2) : '0.00';
                                $currencySymbol = $current_currency->sign ?? $current_currency->name; // Choose sign or name
                                @endphp
                        
                                @if($gs->currency_format)
                            
                                    @if($current_currency->sign)
                                      
                                        {{ $formatedOptionPrice }} {{ $current_currency->sign }}
                                    @else
                                  
                                        {{ $formatedOptionPrice }} {{ $current_currency->name }}
                                    @endif
                                @else
                        
                                    @if($current_currency->sign)
                                    
                                        {{ $current_currency->sign }} {{ $formatedOptionPrice }}
                                    @else
                                        
                                        {{ $formatedOptionPrice }} {{ $current_currency->name }} 
                                    @endif
                                @endif  
                                      
                            </strong></td>
                        </tr>
                    </tfoot>    
                </table></div>
                @if($paymentMethodName !== 'creditCard')
                <button class="button pull-right" wire:click="placeOrder"><span>Place Order</span></button>
                @endif
                @if(session()->has('paymentStatus'))
                @if(session()->get('paymentStatus') == 'Completed')
                <button class="button pull-right" wire:click="placeOrder">Finalize Order</button>
                @endif 
                @endif
                @if($paymentMethodName === 'creditCard')  
                <div class="row">
      
                  <div class="col-md-12">
          
                      <div class="panel panel-default credit-card-box">
          
                          <div class="panel-heading display-table" >
          
                                  <h3 class="panel-title" >Process Payment</h3>
          
                          </div>
          
                          <div class="panel-body">
          
              
          
                              @if (Session::has('success'))
          
                                  <div class="alert alert-success text-center">
          
                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
          
                                      <p>{{ Session::get('success') }}</p>
          
                                  </div>
          
                              @endif
          
              
          
                              <form 
          
                                      role="form" 
          
                                      action="{{ route('stripe.post') }}" 
          
                                      method="post" 
          
                                      class="require-validation"
          
                                      data-cc-on-file="false"
          
                                      data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
          
                                      id="payment-form">
          
                                  @csrf
          
              
          
                                  <div class='form-row row'>
          
                                      <div class='col-xs-12 col-md-6 form-group required'>
          
                                          <label class='control-label'>Name on Card</label> <input
          
                                              class='form-control' size='4' type='text'>
          
                                      </div>
          
                               
              
          
          
                                      <div class='col-xs-12 col-md-6 form-group card required'>
          
                                          <label class='control-label'>Card Number</label> <input
          
                                               class='form-control card-number' size='20'
          
                                              type='text'>

                                             
          
                                      </div>
          
                                  </div>
          
              
          
                                  <div class='form-row row'>
          
                                      <div class='col-xs-12 col-md-4 form-group cvc required'>
          
                                          <label class='control-label'>CVC</label> <input 
          
                                              class='form-control card-cvc' placeholder='ex. 311' size='4'
          
                                              type='text'>
                                             
                                      </div>
          
                                      <div class='col-xs-12 col-md-4 form-group expiration required'>
          
                                          <label class='control-label'>Expiration Month</label> <input
          
                                              class='form-control card-expiry-month' placeholder='MM' size='2'
          
                                              type='text'>
          
                                      </div>
          
                                      <div class='col-xs-12 col-md-4 form-group expiration required'>
          
                                          <label class='control-label'>Expiration Year</label> <input
          
                                              class='form-control card-expiry-year' placeholder='YYYY' size='4'
          
                                              type='text'>
          
                                      </div>
          
                                  </div>
          
              
          
                                  <div class='form-row row'>
          
                                      <div class='col-md-12 error form-group hide'>
          
                                          <div class='alert-danger alert'>Please correct the errors and try
          
                                              again.</div>

                                            
                                      </div>
          
                                  </div>
          
                                  
          
                                  <div class="row">
          
                                      <div class="col-xs-12">
                                       
                                          <button class="btn btn-primary btn-lg btn-block" type="submit">Place Order</button>
          
                                      </div>
          
                                  </div>
          
                                      
          
                              </form>
          
                          </div>
          
                      </div>        
          
                  </div>
          
              </div>
      
                @endif 
            </div>

         
        </div>
      </div>
      <aside class="right sidebar col-sm-3 col-xs-12">
        <div class="sidebar-checkout block">
         <div class="sidebar-bar-title">
              <h3>Your Checkout</h3>
            </div>
                 <div class="block-content">
            <dl>
              <dt class="complete" @click="billingAddressOpen=!billingAddressOpen"> Billing Address <span class="separator">|</span> <a href="javascript:;" x-show="!billingAddressOpen" x-cloak>Change</a>
                <a href="javascript:;" x-show="billingAddressOpen" x-cloak>Close</a>
            </dt>
              <dd class="complete">
                <address>
                {{ session()->has('billingName') ? $billingName : 'John Doe' }}<br>
                {{ session()->has('companyName') ? $companyName : 'No Company ' }}<br>
                {{ session()->has('billingZip') ? $billingZip  : '12343' }}  <br>
                {{ session()->has('billingCity') ? $billingCity : 'No city' }} <br>
                {{ session()->has('billingAddress') ? $billingAddress : 'No address found' }}<br>
                {{ session()->has('billingState') ? $billingState : 'No state Selected' }}<br>
                Phone: {{ session()->has('billingPhone') ? $billingPhone : 'No phone found' }} <br>
             
                </address>
              </dd>
              <dt class="complete" @click="shippingAddressOpen=!shippingAddressOpen"> Shipping Address <span class="separator">|
                <a href="javascript:;" x-show="!shippingAddressOpen" x-cloak>Change</a>
                <a href="javascript:;" x-show="shippingAddressOpen" x-cloak>Close</a>    
            </dt>
              <dd class="complete">
                 <address>
                    {{ session()->has('billingName') ? $billingName : 'John Doe' }}<br>
                    {{ session()->has('companyName') ? $companyName : 'No Company ' }}<br>
                    {{ session()->has('billingZip') ? $billingZip  : '12343' }}  <br>
                    {{ session()->has('billingCity') ? $billingCity : 'No city' }} <br>
                    {{ session()->has('billingAddress') ? $billingAddress : 'No address found' }}<br>
                    {{ session()->has('billingState') ? $billingState : 'No state Selected' }}<br>
                    Phone: {{ session()->has('billingPhone') ? $billingPhone : 'No phone found' }} <br>
                    {{ session()->has('receiverFax') ? 'Fax :' . $receiverFax : 'No fax found'}} <br>
                </address>
              </dd>
              <dt class="complete" @click="shippingMethodOpen=!shippingMethodOpen"> Shipping Method <span class="separator">|</span> 
                <a href="javascript:;" x-show="!shippingMethodOpen" x-cloak>Change</a>
                <a href="javascript:;" x-show="shippingMethodOpen" x-cloak>Close</a>  
             </dt>
              <dd class="complete"> {{ session()->has('shippingMethodName') ? $shippingMethodName : 'No shipping method' }} <br>
                <span class="price">
                    @php
                    $selectedShippingPrice = $selectedShippingMethodPrice ? round($selectedShippingMethodPrice*$current_currency->value,2) : '0.00';
                    $currencySymbol = $current_currency->sign ?? $current_currency->name; // Choose sign or name
                    @endphp
            
                    @if($gs->currency_format)
                
                        @if($current_currency->sign)
                          
                            {{ $selectedShippingPrice }} {{ $current_currency->sign }}
                        @else
                      
                            {{ $selectedShippingPrice }} {{ $current_currency->name }}
                        @endif
                    @else
                
                        @if($current_currency->sign)
                        
                            {{ $current_currency->sign }} {{ $selectedShippingPrice }}
                        @else
                            
                            {{ $selectedShippingPrice }} {{ $current_currency->name }} 
                        @endif
                    @endif
                </span> </dd>
              <dt> Payment Method </dt>
              <dd class="complete">
                <span class="price">{{ $paymentMethodName ?? 'No payment Method ' }}</span>
              </dd>
            </dl>
          </div>
         
        </div>
       
        </aside>
    </div>
  </div>
  </section>
  <livewire:front.components.dispatcher/>
</div>
@push('js')
<script type="text/javascript">
    $(function() {
        /*------------------------------------------
        --------------------------------------------
        Stripe Payment Code
        --------------------------------------------
        --------------------------------------------*/
        
        var $form = $(".require-validation");
        
        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                                 'input[type=text]', 'input[type=file]',
                                 'textarea'].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
    
            $errorMessage.addClass('hide');
        
            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });
            if (!$form.data('cc-on-file')) {
                e.preventDefault();
    
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
               
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val(),
                }, stripeResponseHandler);
            }
        });
    
        /*------------------------------------------
        --------------------------------------------
        Stripe Response Handler
        --------------------------------------------
        --------------------------------------------*/
        function stripeResponseHandler(status, response) {
          
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                // token contains id, last4, and card type
                var token = response['id'];
                
                // Append the token and amount to the form before submitting
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
         
                $form.get(0).submit();
            }
        }
    });
    </script>
    
@endpush