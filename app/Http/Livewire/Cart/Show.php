<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;
use App\Models\Coupon;
use App\Models\Shipping;
use App\Models\Cart;


class Show extends Component
{
    public $coupon_name;
    public $shipping_id = 0;
    public $shipping_dropdown;
    public $coupon_error;
    public $after_discount_subtotal = 0;

public function apply_coupon($vendor_id,$subtotal){

    if(!$this->coupon_name){
        $this->coupon_error = "Coupon is required";
         $this->after_discount_subtotal = 0;
         session(['coupon_info' => '']);
    }
    else{
        $this->coupon_error = " ";
        if(Coupon::where('coupon_name', $this->coupon_name)->exists()){
            $coupon = Coupon::where('coupon_name', $this->coupon_name)->first();
            if($coupon->vendor_id != $vendor_id){
                $this->coupon_error = "This coupon is not for this vendor";
                $this->after_discount_subtotal = 0;
                session(['coupon_info' => '']);
            }
            else{
                // $subtotal;
                if(Coupon::where('coupon_name', $this->coupon_name)->first()->coupon_minimum_value <= $subtotal){
                    session(['coupon_info' => $coupon]);
                    // if($coupon->discount_type == 'flat'){
                    //     $this->after_discount_subtotal =  $subtotal - $coupon->coupon_discount_amount;

                    // }
                    // else{
                    //     $this->after_discount_subtotal =  $subtotal - (($coupon->coupon_discount_amount * $subtotal)/100);
                    // }
                }
                else{
                    $short = Coupon::where('coupon_name', $this->coupon_name)->first()->coupon_minimum_value - $subtotal;
                    $this->coupon_error = "Minimum Purchase amount does not reach, Short by: $short";
                    $this->after_discount_subtotal = 0;
                    session(['coupon_info' => '']);
                }
            }

        }
        else{
            $this->coupon_error = "This coupon does not exist";
            $this->after_discount_subtotal = 0;
            session(['coupon_info' => '']);
            $this->coupon_name = " ";
        }
    }
}

public function UpdatedShippingDropdown($id){
  $this->shipping_id = $id;
  if($id == 0){
    session(['shipping_charge' => 0]);
  }
  else{
      session(['shipping_charge' => Shipping::findorFail($id)->charge]);
    }


}
public function cart_delete($id){
    Cart::find($id)->delete();
}

public function decrement($id){
    Cart::find($id)->decrement('quantity');
}

public function increment($id){
    Cart::find($id)->increment('quantity');
}
public function input_cart_amount($id, $quantity){
    Cart::find($id)->update([
        'quantity' => $quantity,
    ]);
}

public function render(){
    $carts = Cart::where('user_id', auth()->id())->get();
    $shippings = Shipping::all();
    return view('livewire.cart.show', compact('carts','shippings'));
}

}



?>
