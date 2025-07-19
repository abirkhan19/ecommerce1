<?php 

namespace App\Traits;

use App\Models\Product;

trait AddToCompare{
    public function addToCompare($productId)
{
    // Find the main product by ID
    $mainProduct = Product::find($productId);
    
    // If the product does not exist, show error
    if (!$mainProduct) {
        toastr()->error('Product not found.');
        return; // Exit the method if the product is not found
    }

    // Retrieve the existing compare products from the session
    $compareProducts = session()->get('compare.products', []);

    // Check if the compare list has products and compare categories/subcategories/child categories
    if (count($compareProducts) > 0) {
        // Get the category, subcategory, and child category of the first product in the list
        $firstProduct = $compareProducts[0];
        
        // Check if the new product's category, subcategory, and child category match the first product
        if ($mainProduct->category->id !== $firstProduct->category->id ||
            $mainProduct->subcategory->id !== $firstProduct->subcategory->id ||
            $mainProduct->childCategory->id !== $firstProduct->childCategory->id) {
            
            // If they don't match, show an error and prompt to clear the compare list
            toastr()->error('This product is not comparable with the products already in the compare list. Please clear the compare list.');
            return; // Exit the method and do not add the product
        }
    }

    // Check if the compare list already has 4 products
    if (count($compareProducts) >= 4) {
        toastr()->error('You can compare only 4 products at a time.');
        return; // Exit the method if there are already 4 products in the compare list
    }

    // Add the new product to the compare list
    $compareProducts[] = $mainProduct;

    // Save the updated compare list to the session
    session()->put('compare.products', $compareProducts);

    // Show success message
    toastr()->success('Product added to comparison.');
}

    public function removeFromCompare($productId)
    {
        // Retrieve the compare products from session, if any
        $compareProducts = session()->get('compare.products', []);

        // Find the product in the compare list
        $compareProducts = array_filter($compareProducts, function($product) use ($productId) {
            return $product->id != $productId;
        });

        // Reindex the array after filtering out the removed product
        $compareProducts = array_values($compareProducts);

        // Save the updated compare products back to session
        session()->put('compare.products', $compareProducts);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Product removed from comparison.');
    }
    public function getComparedItems()
    {
        if(session()->has('compare.products')){
            return session()->get('compare.products');
        }
    }
}
