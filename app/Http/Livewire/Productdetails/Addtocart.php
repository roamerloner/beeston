<?php

namespace App\Http\Livewire\Productdetails;

use Livewire\Component;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Cart;
use Carbon\Carbon;

class Addtocart extends Component
{
    public $product_id;
    public $size_dropdown;
    public $color_dropdown;
    public $available_colors;
    public $stock = 0;
    public $unit_price = 0;
    public $total_price = 0;
    public $count = 1;
    public $visibility = 'd-none';
    public $inventory;

    public function decrement()
    {
        if($this->count > 1){
        $this->count--;
        $this->total_price = $this->unit_price*$this->count;
        }
    }
    public function increment()
    {
        if($this->count < $this->stock){
          $this->count++;
          $this->total_price = $this->unit_price*$this->count;
        }
    }
    public function updatedSizeDropdown($size_id)
    {
        $this->stock = 0;
        $this->visibility = "d-none";
    //   $this->test = "change hoise $size_id";
    $this->available_colors =  Inventory::where('product_id', $this->product_id)->where('size_id', $size_id)->get();
    }

    public function updatedColorDropdown($inventory_id)
    {
        $this->inventory = Inventory::find($inventory_id);
        $this->stock = $this->inventory->quantity;
        if(Product::find($this->inventory->product_id)->discounted_price){
            $this->unit_price = Product::find($this->inventory->product_id)->discounted_price;
        }
        else{
            $this->unit_price = Product::find($this->inventory->product_id)->regular_price;
        }
        $this->visibility = " ";
        // $this->color_dropdown = $inventory_id;
    //   $this->test = "change hoise $size_id";
    // $this->available_colors =  Inventory::where('product_id', $this->product_id)->where('size_id', $size_id)->get();
    }


    public function addtocartbtn()
    {
       if( Cart::where([
        'user_id' =>auth()->id() ,
        'product_id' =>$this->inventory->product_id,
        'color_id' =>$this->inventory->color_id,
        'size_id' =>$this->inventory->size_id,
        ])->exists()){

            Cart::where([
                'user_id' =>auth()->id() ,
                'product_id' =>$this->inventory->product_id,
                'color_id' =>$this->inventory->color_id,
                'size_id' =>$this->inventory->size_id,
                ])->increment('quantity', $this->count);

        }
        else{
            Cart::insert([
                'user_id' =>auth()->id() ,
                'product_id' =>$this->inventory->product_id,
                'color_id' =>$this->inventory->color_id,
                'size_id' =>$this->inventory->size_id,
                'vendor_id' =>$this->inventory->vendor_id,
                'quantity' =>$this->count,
                'created_at' => Carbon::now()
            ]);
        }
        $this->available_colors = "";
        $this->visibility = 'd-none';
    }




    public function render()
    {
        $available_sizes = Inventory::select('size_id')->where('product_id', $this->product_id)->groupBy('size_id')->get();
        return view('livewire.productdetails.addtocart', compact('available_sizes'));
    }
}
