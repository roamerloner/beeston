@extends('layouts.dashboardmaster')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Product Add</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product Add</h4>
                </div>
                <div class="card-body">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="basic-form">
                      <div class="mb-3">
                        <label for="" class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="name" placeholder="">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        {{-- <input type="text" class="form-control" name="name" placeholder=""> --}}
                        <select name="category_id" class="form-control" id="category_dropdown">
                            <option value="">--Select one Category--</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Purchase Price</label>
                        <input type="number" class="form-control" name="purchase_price" placeholder="">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Regular Price</label>
                        <input type="number" class="form-control" name=" regular_price" placeholder="">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Discounted Price</label>
                        <input type="number" class="form-control" name="discounted_price" placeholder="">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote"  rows="4" id="summernote"></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Short Description</label>
                        <textarea name=" short_description" class="form-control summernote"  rows="4" id="summernote2"></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Additional Information</label>
                        <textarea name="addtional_information" class="form-control"  rows="4"></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Thumbnail</label>
                        <input type="file" class="form-control" name="thumbnail">
                         @error('category_photo')
                            <span class="text-danger">{{ $message }}</span>
                         @enderror
                      </div>
                      <div class="mb-3">
                        <button type="submit" class="btn btn-info">Add Product</button>
                      </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
<script>
        $(document).ready(function() {
        $('#category_dropdown').select2();
    });
</script>

@if (session('success'))
<script>
            const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        })

        Toast.fire({
        icon: 'success',
        title: "{{ session('success') }}",
        })
</script>

@endif

@endsection
