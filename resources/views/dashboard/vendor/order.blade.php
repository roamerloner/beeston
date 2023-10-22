@extends('layouts.dashboardmaster')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">List Product</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product List</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                      <table class="table table-bordered" id="category_table">
                        <thead>
                            <tr>
                                <th>Order No.</th>
                                <th>Customer Name</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Order Total</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($invoices as $invoice)
                            <tr>
                             <td>
                                 {{ $invoice->id }}
                             </td>
                              <td>
                                 {{ $invoice->customer_name }}
                             </td>
                             <td>
                                 {{ $invoice->payment_method }}
                             </td>
                             <td>
                                 {{ $invoice->payment_status }}
                             </td>
                             <td>
                                 {{ $invoice->order_status }}
                             </td>
                             <td>
                                 {{ $invoice->order_total }}
                             </td>
                             <td>
                                 {{ $invoice->created_at->diffForHumans() }}
                             </td>
                             <td>
                                    <form action="{{ route('vendor.order.status.change', $invoice->id) }}" method="POST">
                                      @csrf
                                        <select onchange="this.form.submit()" name="order_status">
                                            <option value="">--Change Order Status--</option>
                                            <option {{ ($invoice->order_status == 'packaging') ? 'selected' : '' }}  value="packaging">Packaging</option>
                                            <option {{ ($invoice->order_status == 'shipping') ? 'selected' : '' }} value="shipping">Shipping</option>
                                            <option {{ ($invoice->order_status == 'delivered') ? 'selected' : '' }} value="delivered">Delivered</option>
                                        </select>

                                    </form>
                             </td>
                            </tr>
                            <tr style="background-color: rgb(224, 223, 223)">
                                <td colspan="50">
                                    <p>Order Details</p>
                                        @foreach ($invoice->invoice_detail as $single_product)
                                            <h6>{{  $single_product->relationshipwithProduct->name}} ({{  $single_product->unit_price }} X  {{ $single_product->quantity}}) = {{  $single_product->unit_price *  $single_product->quantity }}</h6>
                                        @endforeach
                                        {{-- {{ App\ }} --}}
                                </td>
                            </tr>
                           @endforeach
                        </tbody>
                      </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
