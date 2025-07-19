@foreach($section->simpleComponents as $simpleComponent)
<div class="row" style="margin-top:10px;margin-bottom:10px;">

<div class="col-xs-12 col-sm-12">
    <div class="entry-detail">
     
      <div class="entry-photo">
        <figure><img src="{{ asset('front/theme/images/sections/section-'.$section->id.'-page-'.$page->id.'/'.$simpleComponent->image) }}" alt="Blog"></figure>
     
      </div>
     
      <div class="content-text clearfix">
        <?=$simpleComponent->content;?>
      </div>
      
    </div>
   

</div>
</div>
@endforeach
