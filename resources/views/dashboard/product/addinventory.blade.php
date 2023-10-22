@extends('layouts.dashboardmaster')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Product Add</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Inventory - {{ $product->name }}</h4>
                </div>
                <div class="card-body">
                <form action="{{ route('product.add.inventory.post', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="basic-form">
                      {{-- <input type="text" class="form-control" name="name" placeholder=""> --}}
                      <div class="mb-3">
                        <label for="" class="form-label">Color</label>
                        <select name="color_id" class="form-control" >
                            <option value="">--Select one Color--</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="mb-3">
                         {{-- <input type="text" class="form-control" name="name" placeholder=""> --}}
                        <label for="" class="form-label">Size</label>
                        <select name="size_id" class="form-control" id="">
                            <option value="">--Select one Size--</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->size }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="mb-3">
                        {{-- <input type="text" class="form-control" name="name" placeholder=""> --}}
                       <label for="" class="form-label">Quantity</label>
                        <input name="quantity" type="text" class="form-control">
                     </div>
                      <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-info">Add Inventory</button>
                      </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">List Inventory - {{ $product->name }}</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-borderless table-primary align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Color Name</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Resale</th>
                            </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @php
                                    $total_resale_value = 0;
                                @endphp
                                @foreach ($inventories as $inventory)

                                    <tr class="table-primary">
                                        <td>{{ App\Models\Color::find($inventory->color_id)->color_name }}({{ App\Models\Color::find($inventory->color_id)->color_code }})</td>
                                        <td>{{ App\Models\Size::find($inventory->size_id)->size }}</td>
                                        <td>{{ $inventory->quantity }}</td>
                                        <td>{{ $inventory->quantity * $product->purchase_price }} TK</td>
                                        @php
                                            $total_resale_value += ($inventory->quantity * $product->purchase_price);
                                        @endphp
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th>{{ $total_resale_value }} TK</th>
                                </tr>
                            </tfoot>
                    </table>
                  </div>

                </div>
            </div>
        </div>
    </div>
@endsection


