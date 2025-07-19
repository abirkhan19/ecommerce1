<?php

namespace App\Livewire\Front\Components;

use App\Models\Product;
use Livewire\Component;

class TopSearch extends Component
{
    public $searchTop;
    public $searchTopCategoryId;
    public $autoCompleteProducts=[];

    public function render()
    {
      
        return view('livewire.front.components.top-search',[
            'autoCompleteProducts' => $this->autoCompleteProducts
        ]);
    }

    public function getAutoCompleteProducts()
    {
        $this->autoCompleteProducts = Product::when($this->searchTopCategoryId, function($query, $searchTopCategoryId){
            return $query->where('category_id', $searchTopCategoryId);
        })->when($this->searchTop, function($query, $searchTop){
            return $query->where('name', 'like', '%'.$searchTop.'%');
        })->get();
    }

    public function updatedSearchTop()
    {
        if($this->searchTop)
        {
            $this->getAutoCompleteProducts();
        }else{
            $this->autoCompleteProducts = [];
        }
    }

    public function updatedSearchTopCategoryId()
    {
        if(is_numeric($this->searchTopCategoryId))
        {
            $this->getAutoCompleteProducts();
        }else{
            $this->autoCompleteProducts = [];
        }
    }
}
