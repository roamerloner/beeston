<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class VendorController extends Controller
{
    public function vendor_registration()
    {
        return view('frontend.vendor.register');
    }
    public function vendor_login()
    {
        return view('frontend.vendor.login');
    }

    public function vendor_registration_post(Request $request)
    {


         $request->validate([
            '*' => 'required',
        ]);

        // New way inserting

        User::insert($request->except('_token', 'password', 'password_confirmation')+[
               'email_verified_at' => Carbon::now(),
               'created_at' => Carbon::now(),
               'password' => bcrypt($request->password),
               'role' => 'vendor',
               'action' => false,
        ]);

        //  Old way inserting

        // User::insert([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'email_verified_at' => Carbon::now(),
        //     'password' => bcrypt($request->password),
        //     'phone_number' => $request-> phone_number,
        //     'created_at' => Carbon::now(),
        //     'role' => 'vendor',
        // ]);
        return back();
    }

    public function vendor_order_status_change(Request $request, $id)
    {
         Invoice::find($id)->update([
            'order_status' => $request->order_status
         ]);

         if($request->order_status == 'delivered'){
            if(Invoice::find($id)->payment_method == 'cod'){
                Invoice::find($id)->update([
                    'payment_status' => 'paid'
                ]);
            }
         }
         return back();
    }
    public function vendor_order()
    {
        $invoices = Invoice::with([
            'invoice_detail' => function ($q) {
                $q->with('relationshipwithProduct');
            }

        ])->where('vendor_id', auth()->id())->get();
        return view('dashboard.vendor.order', compact('invoices'));
    }

    public function vendor_login_post(Request $request)
    {

        if(User:: where('email', $request->email)->exists()){
            if(User:: where('email', $request->email)->first()->role == 'vendor'){
                if(User:: where('email', $request->email)->first()->action == true){
                    if (Auth::attempt(['email' => $request->email, 'password' =>$request->password])) {
                        return redirect('home');
                        echo "Your email or password is Good!";
                    }
                        else{
                            echo "Your email or password is wrong!";
                        }

                }else{
                    echo "Your account is not approved yet!";
                }

            }
            else{
                echo "you are not a vendor";
            }
        }
        else{
            echo "nai";
        }
    }
}
