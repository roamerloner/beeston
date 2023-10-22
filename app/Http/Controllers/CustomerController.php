<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_details;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{

    public function customer_login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' =>$request->password])) {
           return redirect('home');
        }
        else{
            echo "Your email or password is wrong!";
        }
    }

    public function download_invoice($id)
    {
        $invoice = Invoice::find($id);
        $invoice_details = Invoice_details::where('invoice_id', $id)->get();
                // return $id;

        $pdf = Pdf::loadView('pdf.invoice', compact('invoice','invoice_details'));
        return $pdf->setPaper('a4', 'portrait')->stream(time().'-Invoice('.$id.').pdf');
    }

    public function download_invoice_all($id)
    {
        // return $id;
        // return Invoice::where('user_id', $id)->get();
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }

    public function account()
    {
        return view('frontend.account');
    }

    public function customer_register(Request $request)
    {
        $request->validate([
            '*' => 'required',
        ]);

        $id = User::insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'customer',
            'created_at' => Carbon::now(),

        ]);
        //send email verification mail

        User::find($id)->sendEmailVerificationNotification();
        return back()->with('customer_success', 'Your account created successfully! A verfication email is send to your mail');
    }
}
