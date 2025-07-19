<div>
                
  
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a title="{{ $langg->lang17 }}" href="{{ route('front.index') }}">{{ $langg->lang17 }}</a><span>&raquo;</span></li>
           
            <li><strong>{{ $langg->lang228 }}</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumbs End --> 

  <!-- Main Container -->
  <section class="main-container col1-layout">
    <div class="main container">
      <div class="row">
        <section class="col-main col-sm-12">
          
          <div id="contact" class="page-content page-contact">
          <div class="page-title">
            <h2>{{ $langg->lang228 }}</h2>
          </div>
            <div id="message-box-conact">We're available for new projects</div>
            <div class="row">
              <div class="col-xs-12 col-sm-6" id="contact_form_map">
                <h3 class="page-subheading">Let's get in touch</h3>
                <p>Lorem ipsum dolor sit amet onsectetuer adipiscing elit. Mauris fermentum dictum magna. Sed laoreet aliquam leo. Ut tellus dolor dapibus eget. Mauris tincidunt aliquam lectus sed vestibulum. Vestibulum bibendum suscipit mattis.</p>
                <br/>
                <ul>
                  <li>Praesent nec tincidunt turpis.</li>
                  <li>Aliquam et nisi risus.&nbsp;Cras ut varius ante.</li>
                  <li>Ut congue gravida dolor, vitae viverra dolor.</li>
                </ul>
                <br/>
                <ul class="store_info">
                  <li><i class="fa fa-home"></i>7064 Lorem Ipsum Vestibulum 666/13</li>
                  <li><i class="fa fa-phone"></i><span>+ 012 315 678 1234</span></li>
                  <li><i class="fa fa-fax"></i><span>+39 0035 356 765</span></li>
                  <li><i class="fa fa-envelope"></i>Email: <span><a href="../cdn-cgi/l/email-protection#f98a8c8989968b8db9938c8a8d8d919c949cd79a9694"><span class="__cf_email__" data-cfemail="ed9e989d9d829f99ad87989e9999858880889b8c81818894c38e8280">[email&#160;protected]</span></a></span></li>
                </ul>
                <?=$gs->map;?>

              </div>
              <div class="col-sm-6">
                <h3 class="page-subheading">{{ $langg->lang23 }}</h3>
                <div class="contact-form-box">
                  <div class="form-selector">
                    <label>{{ $langg->lang288 }} <span class="text-danger">*</span></label>
                    <input type="text" wire:model="contactName" class="form-control input-sm" id="name" />
                    @error('contactName') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-selector">
                    <label>{{ $langg->lang289 }} <span class="text-danger">*</span></label>
                    <input type="text" wire:model="contactEmail" class="form-control input-sm" id="email" />
                    @error('contactEmail') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-selector">
                    <label>{{ $langg->lang280 }}</label>
                    <input type="text" wire:model="contactPhone" class="form-control input-sm" id="phone" />
                    @error('contactPhone') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-selector">
                    <label>{{ $langg->lang359 }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" wire:model="contactMessage" rows="30" style="height:50px;"></textarea>
                    @error('contactMessage') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-selector">
                    <label>Security Code <span class="text-danger">*</span></label>
                    <input class="form-control input-sm" type="text" id="captcha" wire:model="contactCaptcha" />
                    @error('contactCaptcha') <span class="text-danger">Please resolve captcha challenge</span> @enderror
                    <br>
                    {!! captcha_img() !!} <button class="btn btn-primary" wire:click="regenerateCaptcha" style="height:40px;"><i class="fa fa-exchange"></i></button>
                  </div>
                  <div class="form-selector">
                    <button class="button" wire:click="sendMessage"><i class="fa fa-send"></i>&nbsp; <span>{{ $langg->lang362 }}</span></button>
                    &nbsp; <a href="javascript:;" wire:click="clearModels" class="button">Clear</a> </div>
                </div>
              </div>
            </div>
          </div>
        </section>
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
