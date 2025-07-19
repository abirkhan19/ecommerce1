<div>
    <div class="top-search">
        <div id="search" style="position: relative;"> <!-- Add relative positioning here -->
          <div class="search-form" >
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search" wire:model.live.debounce.300ms="searchTop">
              <select class="cate-dropdown hidden-xs hidden-sm" wire:model.live="searchTopCategoryId">
                <option>All Categories</option>
                @foreach($categories as $searchCategories)
                    <option value="{{ $searchCategories->id }}">{{ $searchCategories->name }}</option>
                @endforeach
              </select>              
              <button class="btn-search" type="button"><i class="fa fa-search"></i></button>
            </div>

            <!-- Autocomplete dropdown -->
            @if(!empty($autoCompleteProducts))
            <div class="auto-complete" style="position: absolute; top: 40px; left: 50%; transform: translateX(-50%); z-index: 1000; width: 500px;">
                <div class="autocomplete-dropdown" style="position: absolute; top: 100%; z-index: 1001; background: white; border: 1px solid #ddd;">
                    <ul style="list-style:none; max-height:200px; overflow-y:auto; padding: 0;">
                        @foreach($autoCompleteProducts as $autoCompleteProduct)
                            <li style="padding: 10px; display: flex; align-items: center; margin:5px;">
                                <a href="{{ route('product.details', $autoCompleteProduct->slug) }}" style="color: #000; display: flex; width: 100%; align-items: center; text-decoration: none;">
                                   <span style="margin-left:2px;"> <img src="{{ asset('assets/images/products/' . $autoCompleteProduct->photo) }}" 
                                    alt="{{ $autoCompleteProduct->name }}" 
                                    style="width: 40px; height: 50px; margin-right: 10px; object-fit: cover;"></span>
                                    <span style="margin-right:2px;">{{ \Illuminate\Support\Str::limit($autoCompleteProduct->name, 30) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        
        
          </div>
        </div>
      </div>
</div>

