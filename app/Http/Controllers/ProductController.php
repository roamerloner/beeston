<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Size;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('dashboard.product.index', [
           'products' => Product::where('vendor_id', auth()->id())->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.product.create',[
            'categories' => Category::get(['id','category_name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            // echo Product::insert($request->except('_token') + [
            //     'vendor_id' => auth()->id(),
            //     'thumbnail' => "Yo"
            // ]);

            $product =  Product::create($request->except('_token') + [
                'vendor_id' => auth()->id()
            ]);
            // echo $product->id;
            // die();
            if($request->hasFile('thumbnail')){
             $new_name = $product->id."-".Carbon::now()->format('Y_m_d').".".$request->file('thumbnail')->getClientOriginalExtension();
            $img = Image::make($request->file('thumbnail'))->resize(300, 300);
            $img->save(base_path('public/uploads/product_thumbnail/'.$new_name), 60);

            Product::find($product->id)->update([
            'thumbnail' => $new_name
            ]);
            }

            return back()->with('success', "Product added successfully!");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function addinventory(Product $product)
    {
        // return  $product;
        $colors = Color::where('user_id', auth()->id())->latest()->get();
        $sizes = Size::where('user_id', auth()->id())->latest()->get();
        $inventories = Inventory::where([
            'vendor_id' => auth()->id(),
            'product_id' => $product->id,
        ])->get();
        return view('dashboard.product.addinventory', compact('product', 'colors', 'sizes', 'inventories'));
    }
    public function addinventorypost (Product $product, Request $request)
    {
        $inventory = Inventory::where([
            'product_id'=>$product->id,
            'vendor_id'=>$product->vendor_id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
        ])->first();
        echo $inventory;
        if($inventory){
            $inventory->increment('quantity', $request->quantity);
            $inventory->save();
        }
        else{
        Inventory::insert([

            'product_id'=>$product->id,
            'vendor_id'=>$product->vendor_id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>  Carbon::now()
        ]);
        }
            return back();
    }
}
