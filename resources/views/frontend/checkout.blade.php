@extends('layouts.frontendmaster')


@section('content')
    <!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="{{ route('index') }}">Home</a></li>
                        <li>Cart</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->


 <div class="container">
   <form action="{{ route('checkout.post') }}" method="POST">
     @csrf
     <div class="row my-5">
            <div class="col-8">
                <div class="card text-start">
                  <div class="card-header">
                     <h4>Billing Information</h4>
                  </div>
                  <div class="card-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control" name="customer_name" value="{{ auth()->user()->name }}">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="customer_email" value="{{ auth()->user()->email }}">
                      </div>
                      <div class="mb-3">
                         <label for="" class="form-label">Phone Number</label>
                         <input type="text" class="form-control" name="customer_phone_number" >
                       </div>

                      <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                              <label for="" class="form-label">Country</label>
                                <select name="customer_country_id" id="country_dropdown" class="form-select">
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->code }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                              <label for="" class="form-label">City</label>
                                <select name="customer_city_id" id="city_dropdown" class="form-select">
                                    <option value="">-- Choose Country First --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Address</label>
                         <textarea name="customer_address" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Remarks</label>
                         <textarea name="customer_remarks" class="form-control" rows="4"></textarea>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-4">
               <div class="card text-start">
                <div class="card-header">
                    <h4>Your Order</h4>
                 </div>
                 <div class="card-body">
                   <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Header</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>After Discount</td>
                                <td>{{ session('after_discount') }}</td>
                            </tr>
                            <tr>
                                <td>Shipping Charge</td>
                                <td>{{ session('shipping_charge') }}</td>
                            </tr>
                            <tr>

                                    <td><b>Order Total</b></td>
                                    <td><b>{{ session('order_total') }}</b></td>


                            </tr>
                        </tbody>
                    </table>
                   </div>
                    <hr>
                    <div class="mb-3">
                        <label for="" class="form-label">Payment Method</label>
                          <select name="payment_method" class="form-select">
                              <option value="">-- Select Payment Method --</option>
                              <option value="cod">Cash On Delivery (COD)</option>
                              <option value="online">Online Payment</option>
                          </select>
                      </div>
                      <div class="mb-3">
                         <button class="btn btn-success">Order Now</button>
                      </div>
                 </div>
               </div>
            </div>

     </div>
    </form>
 </div>


@endsection
@section('footer_scripts')
<script>
  $(document).ready(function(){
    $('#country_dropdown').change(function(){
        var country_code = $(this).val();
         if(country_code){
            //ajax start
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
           });

                $.ajax({
                    type:'POST',
                    url:'/getcitylist',
                    data: {country_code: country_code},
                    success: function(data) {
                      $('#city_dropdown').html(data);
                    }
                });
           //ajax end
           }else{
            alert("Choose a Country");
            $('#city_dropdown').html("");
         }
    });
  });
</script>
@endsection
