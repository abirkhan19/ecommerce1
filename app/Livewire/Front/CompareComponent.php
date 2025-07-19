<?php

namespace App\Livewire\Front;

use App\Models\Product;
use Livewire\Component;
use App\Traits\AddToCompare;

class CompareComponent extends Component
{
    use AddToCompare;

    public $selectedPrices = [];
    public $additionalPrice = 0; 
    public $productTotals = []; 
    public $previousTotals = [];

    public function render()
    {
        $products = session()->get('compare.products', []);
        
       
        $this->calculateTotals($products);

        return view('livewire.front.compare-component', [
            'products' => $products,
            'productTotals' => $this->productTotals,
            'previousTotals' => $this->previousTotals,
        ])->layout('layouts.front');
    }


    public function calculateTotals($products)
    {
        foreach ($products as $product) {
            $productTotal = $product->price + $this->additionalPrice;
            $previousTotal = $product->previous_price + $this->additionalPrice;
            $this->productTotals[$product->id] = $productTotal;
            $this->previousTotals[$product->id] = $previousTotal;
        }
    }

   
    public function incrementProductPrice($attributeKey, $selectedPrice, $productId)
    {
     
        $this->selectedPrices[$productId][$attributeKey] = $selectedPrice;
        $this->additionalPrice = array_sum($this->selectedPrices[$productId]);
        $this->calculateTotals(session()->get('compare.products', []));
    }
}
