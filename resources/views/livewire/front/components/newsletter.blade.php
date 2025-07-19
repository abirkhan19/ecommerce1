<div>
 @if(session()->has('dontshow'))     
 <!--Newsletter Popup Start-->
  <div id="myModal" class="modal fade">
    <div class="modal-dialog newsletter-popup">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="modal-body">
          <h4 class="modal-title">Join Our Newsletters</h4>
          <form id="newsletter-form" method="post" action="index.html#">
            <div class="content-subscribe">
              <div class="form-subscribe-header">
                <label>Enter your email and we'll send you a coupon with 10% off your next order.</label>
              </div>
              <div class="input-box">
                <input type="text" class="input-text newsletter-subscribe" title="Sign up for our newsletter" name="email" placeholder="Enter your email address">
              </div>
              <div class="actions">
                <button class="button-subscribe" title="Subscribe" type="submit">Subscribe</button>
              </div>
            </div>
          </form>
          <div class="subscribe-bottom">
            <button class="btn" wire:click="updatedShowNewsletter(false)">
            Don’t show this popup again </button></div>
        </div>
      </div>
    </div>
  </div>
  <!--End of Newsletter Popup--> 
  @endif
</div>
