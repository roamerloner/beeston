@extends('layouts.dashboardmaster')

@section('content')
 <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Category Name</td>
                                <td>{{ $category->category_name }}</td>
                            </tr>
                            <tr>
                                <td>Category Slug</td>
                                <td>{{ $category->category_slug }}</td>
                            </tr>
                            <tr>
                                <td>Category Photo</td>
                                <td>
                                    <img width="50" src="{{ asset('uploads/category_photos') }}/{{ $category->category_photo }}" alt="not found">
                                </td>
                            </tr>
                            <tr>
                                <td>Created At</td>
                                <td>{{ $category->created_at }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
 </div>
@endsection
