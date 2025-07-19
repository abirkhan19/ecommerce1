<div>
                          
  
    <div class="breadcrumbs">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <ul>
              <li class="home"> <a title="Go to Home Page" href="{{ route('admin.dashboard') }}" target="_blank">Acasa</a><span>&raquo;</span></li>
              <li><strong><a href="{{ route('front.menu',$alterPage->slug) }}" target="_blank">View {{ $alterPage->title }}</a></strong></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  
    <div class="main container">

    @foreach($page->pageSections as $section)  
      <div wire:key="{{ $section->id }}">
      {!! view('components.'.$section->view_name.'',[
        'section' => $section,
        'page' => $page,
        'mode'=>'',
        'alterPageId' => $alterPage,
        'componentType' => $componentType??null,
        'linkId' => $linkId??null,
        'getGalleryImages' => $getGalleryImages??[],
      ]) !!}
      </div>
    @endforeach
 
  </div>
  