<div>
        
  
    <div class="breadcrumbs">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <ul>
              <li class="home"> <a title="Go to Home Page" href="index.html">Home</a><span>&raquo;</span></li>
              <li><strong>My Account</strong></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Breadcrumbs End --> 
    
    <!-- Main Container -->
    <section class="main-container col1-layout">
      <div class="main container">
        
          
          <div class="page-content">
            
              <div class="account-login">
                
     
            
                <div class="box-authentication">
                  <h4>Reset Password</h4>
                 <p class="before-login-text">We will help you with your lost password give us some details....</p>
                  <label for="emmail_login">Email Or Phone<span class="required">*</span></label>
                  <input id="emmail_login" type="text" class="form-control" wire:model.live.debounce.300ms="resetProperty">
                  @if (session()->has('status'))
                        <div class="alert alert-success" style="margin-top:10px;">{{ session('status') }}</div>
                   @endif
                   @error('resetProperty') <span class="text-danger">{{ $message }}</span> @enderror <br>
                  @if($foundUser)
                   <div class="profile-image">
                        <img @if($foundUser) src="{{ asset('front/images/users/'.$foundUser->email.'/'.$foundUser->photo) }}" @else src="{{ asset('front/images/users/noimage.png') }}" @endif  alt="profile image" height="100">
                   </div>
                   @endif 
                   <div class="profile-details" style="margin-top:10px;">
                    <p>{{ $foundUser ? $foundUser->name : '' }}</p>
                   </div>
                  <button class="button" wire:click="sendEmailWithToken"><i class="fa fa-envelope"></i>&nbsp; <span>Send Request</span></button>
                </div>
              
     
      
          </div>
        </div>
  
      </div>
    </section>
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
    
  </div>
  