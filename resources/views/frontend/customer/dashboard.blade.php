@extends('layouts.frontendmaster')

@section('content')
    <!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="index.html">Home</a></li>
                        <li>My Account</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->

            <!-- account_section - start
            ================================================== -->
            <section class="account_section section_space">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 account_menu">
                            <div class="nav account_menu_list flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link text-start active w-100" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Account Dashboard </button>
                                <button class="nav-link text-start w-100" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Acount</button>
                                <button class="nav-link text-start w-100" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">My Orders</button>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="m-5 btn btn-danger">Logout</button>
                            </form>
                        </div>
                        <div class="col-lg-9">
                            <div class="tab-content bg-light p-3" id="v-pills-tabContent">
                                <div class="tab-pane fade show active text-center" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <div class="card border-primary">
                                          <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <h3>Total Orders</h3>
                                                    <h6>{{ $invoices->count() }}</h6>
                                                </div>
                                                 <div class="col-4">
                                                    <h3>Online Payment</h3>
                                                    <h6>{{  $invoices->where('payment_method','online')->count() }}</h6>
                                                </div>
                                                <div class="col-4">
                                                    <h3>Cash on Delivery</h3>
                                                    <h6>{{  $invoices->where('payment_method','cod')->count() }}</h6>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h3>Total Order Value</h3>
                                                    <h6>{{ $invoices->sum('order_total') }}</h6>
                                                </div>
                                                <div class="col-4">
                                                    <h3>Total Paid</h3>
                                                    <h6>{{  $invoices->where('payment_status','paid')->sum('order_total')  }}</h6>
                                                </div>
                                                <div class="col-4">
                                                    <h3>Total Unpaid</h3>
                                                    <h6>{{  $invoices->where('payment_status','unpaid')->sum('order_total') }}</h6>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <hr>
                                        <h1>Charts</h1>
                                        <hr>
                                        {{-- Chart --}}
                                         <div class="card mt-4">
                                          <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <canvas id="payment_method_chart"></canvas>
                                                </div>
                                                <div class="col-6">
                                                    <canvas id="payment_chart"></canvas>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    @if (auth()->user()->created_at->diffInHours(\Carbon\Carbon::now()) < 1)


                                    @endif

                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <h5 class="text-center pb-3">Account Details</h5>
                                    <form class="row g-3 p-2">
                                        <div class="col-md-6">
                                            <label for="inputnamel4" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="inputnamel4" value="Mr. Jon Doe">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputEmail4" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="inputEmail4" value="jon@doe.com">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputPassword4" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="inputPassword4">
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary active">Update</button>
                                        </div>
                                     </form>
                                    </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                    <h5 class="text-center pb-3">Your Orders</h5>
                                    <a href="{{ route('download.invoice.all', auth()->id()) }}" class=" btn btn-sm btn-info mb-2">Download All</a>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>SL</th>
                                            <th>Order no. </th>
                                            <th>Payment Method</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Order Total</th>
                                            <th>Action</th>
                                        </tr>

                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    {{ $invoice->id.'-'. $invoice->created_at->format('d-m-Y') }}
                                                    {{-- <br>
                                                    {!! DNS2D::getBarcodeHTML( $invoice->id.'-'. $invoice->created_at->format('d-m-Y'), 'QRCODE') !!} --}}
                                                </td>
                                                <td>{{ $invoice->payment_method }}</td>
                                                <td>{{ $invoice->payment_status }}</td>
                                                <td>{{ $invoice->order_status }}</td>
                                                <td>{{ $invoice->order_total }}</td>
                                                <td>
                                                    <a href="{{ route('download.invoice', $invoice->id) }}" class="btn btn-primary">Download Invoice</a>
                                                </td>
                                            </tr>

                                        @endforeach

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </section>
    <!-- account_section - end
    ================================================== -->
@endsection

@section('footer_scripts')

<script>
  const ctx = document.getElementById('payment_method_chart').getContext('2d');

 const myChart = new Chart(ctx, {

type: 'pie',
    data: {
        labels: ['Online Payment', 'Cash on Delivery'],
            datasets: [{
             label: '# of Payments',
             data: [{{  $invoices->where('payment_method','online')->count() }}, {{  $invoices->where('payment_method','cod')->count() }}],
             backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)'
                ],
                borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                   ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
    }
  });

  const ctx1 = document.getElementById('payment_chart').getContext('2d');

 const myChart1 = new Chart(ctx1, {

type: 'doughnut',
    data: {
        labels: ['Paid', 'Unpaid'],
            datasets: [{
             label: '# of Payments',
             data: [{{  $invoices->where('payment_status','paid')->sum('order_total')  }},{{  $invoices->where('payment_status','unpaid')->sum('order_total') }}],
             backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)'
                ],
                borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                   ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
    }
  });
</script>


@endsection
