<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Cart;
use Carbon\Carbon;
use Mail;
use App\Mail\ContactMessage;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\Invoice_details;
use Khsing\World\World;
use Khsing\World\Models\Country;

class FrontendController extends Controller
{
    function index(){
        return view('frontend.index',[
            'products' => Product::latest()->get(),
            'categories' => Category::all()
        ]);
    }
    function product_details ($id){

        $product = Product::findOrFail($id);
        $related_products = Product::where('category_id', '=',$product->category_id)->where('id', '!=', $id)->get();
        return view('frontend.product_details ', compact('product', 'related_products'));
    }
    function cart()
    {
        return view("frontend.cart");
    }
    function checkout ()
    {
        $after_explode = explode('/',url()->previous());
        if(end($after_explode) == 'cart'){

            $countries = World::Countries();
            return view("frontend.checkout", compact('countries'));
        }
        else{
            abort(404);
        }
        // return
    }
    function getcitylist(Request $request)
    {
        // $country = Country::getByCode($request->country_code);
        // $cities_from_db = $country->children();
        // return $cities = $cities_from_db->sortBy('name','ASC');

        $country = Country::getByCode($request->country_code);
        $cities_from_db = $country->children();
        $sorted = collect($cities_from_db)->sortBy('name');
        $cities = $sorted->values()->all();

        $generated_city_dropdown = "";
        foreach ($cities as $city) {
            //$generated_city_dropdown .= $city->id."#".$city->name;
            $generated_city_dropdown .= "<option value='$city->id'>$city->name</option>";
        }
       return  $generated_city_dropdown ;

    }
    function checkout_post(Request $request)
    {

        $invoice_id = Invoice::insertGetId([
            'user_id' => auth()->id(),
            'vendor_id' => Cart::where('user_id', auth()->id())->first()->vendor_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone_number' => $request ->customer_phone_number,
            'customer_country_id' => $request ->customer_country_id,
            'customer_city_id' => $request->customer_city_id,
            'customer_address' => $request->customer_address,
            'customer_remarks' => $request->customer_remarks,
            'payment_method' => $request->payment_method,
            'coupon_info' => session('coupon_info')->coupon_name,
            'after_discount' => session('after_discount'),
            'shipping_charge' => session('shipping_charge'),
            'order_total' => session('order_total'),
            'created_at' => Carbon::now()
        ]);

        foreach (Cart::where('user_id', auth()->id())->get() as $cart) {
            if(Product::find($cart->product_id)->discounted_price){
                $unit_price = Product::find($cart->product_id)->discounted_price;

            }
            else{
                $unit_price = Product::find($cart->product_id)->regular_price;
            }

            Invoice_details::insert([
                'invoice_id' => $invoice_id,
                'product_id' => $cart->product_id,
                'color_id' => $cart->color_id,
                'size_id' => $cart->size_id,
                'quantity' => $cart->quantity,
                'unit_price' => $unit_price,
                'created_at' => Carbon::now()
        ]);

        Inventory::where([
                'product_id' => $cart->product_id,
                'color_id' => $cart->color_id,
                'size_id' => $cart->size_id,
        ])->decrement('quantity', $cart->quantity);
            $cart->delete();
        }

        if ($request->payment_method == "cod") {
            return redirect('cart');
        }
        else {
            
            return redirect('pay')->with('invoice_id', $invoice_id);
        }

    }
    function about()
    {
        return view("frontend.about");
    }
    function contact(){
        return view("frontend.contact");
    }
    function contact_post(Request $request){
        Mail::to('kevin1990go@gmail.com')->send(new ContactMessage($request->except('_token')));
        return back();
    }


    function team(){

        // SELECT * FROM teams;
        // $teams = Team::latest()->limit(5)->get();

        //SELECT * FROM teams WHERE id = 5
        //  $teams = Team::find(6);

        // $teams = Team::findorfail();

        // SELECT * FROM teams WHERE phone_number = "01743545334";
        // $teams = Team::where("phone_number", "01743545334")->first();

         // SELECT id, name, phone_number FROM teams WHERE phone_number = "01743545334";
        //  $teams = Team::where("name", "Dylan Stout")->get(['id','name','phone_number']);

        //SELECT * FROM teams WHERE name = 'Dylan Stout' AND phone_number = 016454532342;
        //  echo $teams = Team::where([
        //     "name" => "Dylan Stout",
        //      "phone_number" => "016454532342",
        //  ])->get();

         //SELECT COUNT(*) AS total FROM teams
        //  echo $teams = Team::count();

        //SELECT COUNT(*) AS total FROM teams WHERE name = 'Dylan Stout';
            // echo $teams = Team::where('name', 'Dylan Stout')->count();


         $teams = Team::Paginate(5);
         $teams_count = Team::count();
         $deleted_teams = Team::onlyTrashed()->get();
        return view("team", compact('teams', 'teams_count','deleted_teams'));
    }

    function teaminsert(Request $request){

        $request->validate([
            "name" => 'required|max:30|min:5',
            "phone_number" => 'required'
        ],[
            'name.required' => 'নাম পুড়ন করতে হবে!',
            'phone_number.required' => 'ফোন নাম্বার পুড়ন করতে হবে!'
        ]);

            Team::insert([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'created_at' => Carbon::now()
            ]);
    //         // $_SESSION['success_message'] = "Team Member added successfully";
             return back()->with('success_message', 'Team Member added successfully!');
     }

    function teamdelete($id){
    //   return $id;
      //DELETE FROM teams WHERE id = $id
      if($id == "all"){
        Team::where('deleted_at', NULL)->delete();
      }
      else{
          Team::find($id)->delete();
    }
      return back();
}
function teamedit($id){
    return view('teamedit',[
        'team' => Team::find($id)
    ]);
    // return view('teamedit')->with('team',$team);
    // return view('teamedit', compact('team'));

}

function teameditpost(Request $request, $id){
//   UPDATE teams SET 'name' = $name, 'phone_number' =$phone_number WHERE id = $id;
Team ::find($id)->update([
    'name' => $request->name,
    'phone_number' => $request->phone_number
]);
       return redirect('team');
}

function teamrestore($id){
    // echo $id;
    Team::onlyTrashed()->where('id',$id)->restore();
    return back();
    }

}
