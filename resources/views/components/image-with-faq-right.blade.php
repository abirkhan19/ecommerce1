<div class="row mb-3 mt-3">

  <div class="col-xs-12 col-sm-9">
    <div class="panel-group accordion-faq" id="faq-accordion">
    @foreach($section->pageFaq->where('view_position','right') as $rightFaq)
      <div class="panel">
        <div class="panel-heading"> 
          <a data-toggle="collapse" data-parent="#faq-accordion" href="#question{{ $rightFaq->id }}" class="collapsed" aria-expanded="false"> 
          <span class="arrow-down"><i class="fa fa-angle-down"></i></span> <span class="arrow-up">
            <i class="fa fa-angle-up"></i></span> {{ $rightFaq->title }}</a> </div>
        <div id="question{{ $rightFaq->id }}" class="panel-collapse collapse" aria-expanded="false">
          <div class="panel-body"> 
           {{ $rightFaq->content }}        
          </div>
        </div>
      </div>
    @endforeach
    </div>
  </div>
  <div class="col-sm-3 col-xs-12">       

    <div class="img"><img src="{{ asset('front/theme/images/daily-deal-bg.jpg') }}" alt="faq banner"></div>
   </div>
</div>
