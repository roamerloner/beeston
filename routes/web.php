<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\{SslCommerzPaymentController,CouponController,VariationController,ProductController,FrontendController,HomeController, ProfileController,CustomerController,CategoryController,VendorController};
//Auth routes
Auth::routes(['register' => true]);

//FrontendController
Route::get("/", [FrontendController::class, "index"])->name('index');
Route::get("/product/details/{id}", [FrontendController::class, "product_details"])->name('product.details');
Route::get("/cart", [FrontendController::class, "cart"])->name('cart');
Route::get("/checkout", [FrontendController::class, "checkout"])->name('checkout');
Route::post("/checkout", [FrontendController::class, "checkout_post"])->name('checkout.post');
Route::post("/getcitylist", [FrontendController::class, "getcitylist"])->name('getcitylist');
Route::get("contact", [FrontendController::class,"contact"])->name('contact');
Route::post("contact", [FrontendController::class,"contact_post"])->name('contact.post');
Route::get("about-us", [FrontendController::class, "about"])->name('about');
Route::get("team", [FrontendController::class, "team"]);
Route::post("team/insert", [FrontendController::class, "teaminsert"]);
Route::get("team/delete/{id}", [FrontendController::class, "teamdelete"]);
Route::get("team/edit/{id}", [FrontendController::class, "teamedit"]);
Route::post("team/edit/post/{id}", [FrontendController::class, "teameditpost"]);
Route::get("team/restore/{id}", [FrontendController::class, "teamrestore"]);



//homeController
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'verified']);




//profileController
Route::get('/profile', [ProfileController::class, 'profile']);
Route::post('/profile/photo/update', [ProfileController::class, 'profile_photo_update']);
Route::post('/change/password', [ProfileController::class, 'change_password']);
Route::get('/send/verification/code', [ProfileController::class, 'send_verification_code']);
Route::post('/check/code', [ProfileController::class, 'check_code']);

//customerController
Route::get('/account', [CustomerController::class, 'account'])->name('account');
Route::post('/customer/register', [CustomerController::class, 'customer_register'])->name('customer.register');
Route::post('/customer/login', [CustomerController::class, 'customer_login'])->name('customer.login');
Route::get('/download/invoice/{id}', [CustomerController::class, 'download_invoice'])->name('download.invoice');
Route::get('/download/invoice/all/{id}', [CustomerController::class, 'download_invoice_all'])->name('download.invoice.all');




//Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/vendor/registration', [VendorController::class, 'vendor_registration'])->name('vendor.registration');
Route::get('/vendor/login', [VendorController::class, 'vendor_login'])->name('vendor.login');
Route::post('/vendor/registration', [VendorController::class, 'vendor_registration_post'])->name('vendor.registration.post');
Route::post('/vendor/login', [VendorController::class, 'vendor_login_post'])->name('vendor.login.post');
Route::get('/vendor/order/{id}', [VendorController::class, 'vendor_order'])->name('vendor.order');
Route::post('/vendor/order/status/change/{id}', [VendorController::class, 'vendor_order_status_change'])->name('vendor.order.status.change');

Route::resource("product", ProductController::class);
Route::get('product/add/inventory/{product}', [ProductController::class, 'addinventory'])->name('product.add.inventory');
Route::post('product/add/inventory/{product}', [ProductController::class, 'addinventorypost'])->name('product.add.inventory.post');

Route::resource("variation", VariationController::class);
Route::resource("coupon", CouponController::class);

// Under Admins Eye
Route::middleware(['adminrolechecker'])->group(function () {
    Route::get('/users', [HomeController::class, 'users']);

    //CategoryController
    Route::resource("category", CategoryController::class);

    Route::post('/vendor/action/change/{id}', [HomeController::class, 'vendor_action_change'])->name('vendor.action.change');

    Route::post('/add/user', [HomeController::class, 'add_user'])->name('add_user');
});


// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

