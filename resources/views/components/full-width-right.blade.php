@foreach($section->simpleComponents as $simpleComponent)
<div class="row" style="margin-top:10px;margin-bottom:10px;">
    <div class="col-sm-4">
      <div class="entry-thumb"> <a href="single_post.html">
        <figure><img src="{{ asset('front/theme/images/blog-img3.jpg') }}" alt="Blog"></figure>
      </div>
    </div>
    <div class="col-sm-8">
     <?=$simpleComponent->content;?>
  </div>
</div>
</div>
@endforeach