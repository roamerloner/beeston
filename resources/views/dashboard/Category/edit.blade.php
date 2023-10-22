@extends('layouts.dashboardmaster')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Category Edit</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Category Edit</h4>
                </div>
                <div class="card-body">
                <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="basic-form">
                      <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name" placeholder="" value="{{ $category->category_name }}">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Category Link/Slug</label>
                        <input type="text" class="form-control" name="category_slug" placeholder="" aria-describedby="fileHelpId" value="{{ $category->category_slug }}">
                        <small class="text-info">Type here if you want to change</small>
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Current Category Photo</label>
                        <br>
                        <img src="{{ asset('uploads/category_photos') }}/{{ $category->category_photo }}" alt="">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Category Photo</label>
                        <input type="file" class="form-control" name="category_photo">
                         @error('category_photo')
                            <span class="text-danger">{{ $message }}</span>
                         @enderror
                      </div>
                      <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-info">Edit Category</button>
                      </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
