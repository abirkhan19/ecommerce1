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
                 <p class="before-login-text">Welcome back! Sign in to your account</p>
                  <label for="emmail_login">Email Or Phone<span class="required">*</span></label>
                  <input id="emmail_login" type="text" class="form-control" wire:model="userName">
                  @error('userName') <span class="text-danger">{{ $message }}</span> @enderror <br>
                  <label for="password_login">Password<span class="required">*</span></label>
                  <input id="password_login" type="password" class="form-control" wire:model="loginPassword">
                  @error('password') <span class="text-danger">{{ $message }}</span> @enderror <br>
                  
                  <p class="forgot-pass"><a href="{{ route('user.password-reset') }}">Lost your password?</a></p>
                  <button class="button" wire:click="authenticateUser"><i class="fa fa-lock"></i>&nbsp; <span>Login</span></button><label class="inline" for="rememberme">
                                                      <input type="checkbox" wire:model="rememberMe" id="rememberme" name="rememberme"> Remember me
                                                  </label>
                </div>
                <div class="box-authentication">
                  <h4>Register</h4><p>Create your very own account</p> 											
                  <label for="emmail_register">Name<span class="required">*</span></label>
                  <input id="emmail_register" type="text" class="form-control" wire:model="registerUsername" required>
                  @error('registerUsername') <span class="text-danger">{{ $message }}</span> @enderror <br>
                  <label for="emmail_register">Email address<span class="required">*</span></label>
                  <input id="emmail_register" type="text" class="form-control" wire:model="registerEmail" required>
                  @error('registerEmail') <span class="text-danger">{{ $message }}</span> @enderror <br>
                  <label for="emmail_register">Phone Number<span class="required" >*</span></label>
                  <input id="emmail_register" type="text" class="form-control" wire:model="registerPhoneNumber" required>
                  @error('registerPhoneNumber') <span class="text-danger">{{ $message }}</span> @enderror <br>
                  <label for="emmail_register">Password<span class="required" >*</span></label>
                  <input id="emmail_register" type="password" class="form-control" wire:model="password" required>
                  @error('password') <span class="text-danger">{{ $message }}</span> @enderror <br>
                  <label for="emmail_register">Confirm Password<span class="required" >*</span></label>
                  <input id="emmail_register" type="password" class="form-control" wire:model="password_confirmation" required>
                  @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror <br>
                  <label for="emmail_register">Profile Image<span class="required"></span></label>
                  <input id="emmail_register" type="file" wire:model.live="profileImageInput" class="form-control">
                  @error('profileImageInput') <span class="text-danger">{{ $message }}</span> @enderror <br>
                <div class="profile-image">
                  <img src="{{ asset($imagePath.$profileImage) }}" alt="profile-image" height="100">
                </div>
               
                <div class="captcha" style="margin-top:10px;">
                  {!! captcha_img() !!} <button class="button" height="80" wire:click="regenerateCaptcha"><i class="fa fa-exchange" aria-hidden="true"></i></button>
                </div>
                <label for="emmail_register">Captcha<span class="required">*</span></label>
                <input id="emmail_register" type="text" wire:model="capthcaText" class="form-control">
                @error('capthcaText') <span class="text-danger">Please enter captcha text correctly</span> @enderror <br>
                  <button class="button" wire:click="registerUser"><i class="fa fa-user"></i>&nbsp; <span>Register</span></button>
                  
                  <div class="register-benefits">
                                                  <h5>Sign up today and you will be able to :</h5>
                                                  <ul>
                                                      <li>Speed your way through checkout</li>
                                                      <li>Track your orders easily</li>
                                                      <li>Keep a record of all your purchases</li>
                                                  </ul>
                                              </div>
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
  