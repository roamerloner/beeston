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
                                <th>Product Photo</th>
                                <th>Product Name</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>
                                        @if ($product->thumbnail)
                                            <img src="{{ asset('uploads/product_thumbnail') }}/{{ $product->thumbnail }}" alt="Not Found" width="150">
                                        @else
                                            <img src="{{ Avatar::create($product->name )->setShape('square'); }}" />
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $product->relationshipwithCategory->category_name }}
                                            {{-- Normal Style --}}
                                            {{-- {{ App\Models\Category::find($product->category_id)->category_name }} --}}

                                        </span>
                                    </td>
                                    {{-- <td>
                                        <a class="btn btn-sm btn-info" href="{{ route('category.show', $category->id) }}">Details</a>
                                        <a class="btn btn-sm btn-primary" href="{{ route('category.edit', $category->id) }}">Edit</a>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                            @csrf
                                             @method('DELETE')
                                                <button class="btn btn-sm btn-danger mt-2">Delete</button>
                                        </form>
                                    </td> --}}
                                    <td>
                                        <a href="{{ route('product.add.inventory', $product->id) }}" class="btn btn-sm btn-outline-info">Add Inventory</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="50" class="text-center text-danger">No data to show</td>
                                </tr>
                            @endforelse
                        </tbody>
                      </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
   <script>
      $(document).ready(function () {
        $('#category_table').DataTable();
    });
   </script>
@endsection
