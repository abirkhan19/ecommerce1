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
                  <h4>Login</h4>
                 <p class="before-login-text">Insert and confirm Your new password login will be performed automaticaly</p>
                  <label for="emmail_login">New Password<span class="required">*</span></label>
                  <input id="emmail_login" type="password" class="form-control" wire:model="password">
                  <label for="emmail_login">Confirm Password<span class="required">*</span></label>
                  <input id="emmail_login" type="password" class="form-control" wire:model="password_confirmation">    
                  @if($getUser) 
                  <div class="profile-image" style="margin-top:10px;">
                    <img @if($getUser) src="{{ asset('front/images/users/'.$getUser->email.'/'.$getUser->photo) }}" @else src="{{ asset('front/images/users/noimage.png') }}" @endif  alt="profile image" height="100">
                  </div>  
                  @endif 
                  <div class="user-name" style="margin-top:10px;">
                    <p>{{ $getUser ? $getUser->name : '' }}</p> 
                   </div>         
                  <button class="button" wire:click="changeUsersPassword"><i class="fa fa-key"></i>&nbsp; <span>Reset Password</span></button>
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
  