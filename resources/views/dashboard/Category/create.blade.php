@extends('layouts.dashboardmaster')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Category Add</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Category Add</h4>
                </div>
                <div class="card-body">
                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="basic-form">
                      <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name" placeholder="">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Category Link/Slug</label>
                        <input type="text" class="form-control" name="category_slug" placeholder="" aria-describedby="fileHelpId">
                        <small class="text-info">Type here if you want to change</small>
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Category Photo</label>
                        <input type="file" class="form-control" name="category_photo">
                         @error('category_photo')
                            <span class="text-danger">{{ $message }}</span>
                         @enderror
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Category Color</label>
                        <input type="color" name="category_color">
                      </div>
                      <div class="mb-3">
                        <button type="submit" class="btn btn-info">Add Category</button>
                      </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
