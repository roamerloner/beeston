<?php
 use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Product;


   function cart_total($product_id, $quantity){
      $product = Product::find($product_id);
      if($product->discounted_price){
        $price = $product->discounted_price;
        }
        else{
            $price = $product->regular_price;
        }
            return $price * $quantity;
   }


   function cart_count(){
        return Cart::where('user_id', auth()->id())->count();
   }

function get_inventory($product_id, $color_id,$size_id){
        return Inventory::where([
            'product_id' => $product_id,
            'color_id' => $color_id,
            'size_id' => $size_id,
        ])->first()->quantity;
}
?>
