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
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">Coupon Name</th>
                            <th scope="col">Coupon Minimum Value</th>
                            <th scope="col">Discount Type</th>
                            <th scope="col">Coupon Discount Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->coupon_name }}</td>
                                <td>{{ $coupon->coupon_minimum_value }}</td>
                                <td>{{ $coupon->discount_type }}</td>
                                <td>{{ $coupon->coupon_discount_amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="col-xl-6 col-lg-6">
            <div>
                <div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Create Coupon</h4>
                        </div>
                        <div class="card-body">
                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            <form action="{{ route('coupon.store') }}" method="POST">
                                @csrf
                                <div class="basic-form">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Coupon Name</label>
                                        <input type="text" class="form-control" name="coupon_name" value="{{ Str::upper(Str::random(4)) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Coupon Minimum Value</label>
                                        <input type="number" class="form-control" name="coupon_minimum_value" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Discount Type</label>
                                        <select name="discount_type" class="form-control">
                                            <option value="percentage">Percentage (%)</option>
                                            <option value="flat">Flat Discount (%)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Coupon Discount Amount</label>
                                        <input type="number" class="form-control" name="coupon_discount_amount" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                    <button type="submit" class="btn btn-sm btn-info">Add Coupon</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection




