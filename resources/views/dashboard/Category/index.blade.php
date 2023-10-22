@extends('layouts.dashboardmaster')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Category List</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Category List</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                      <table class="table table-bordered" id="category_table">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->category_name }}</td>
                                    {{-- <td>{{ $category->category_slug }}</td>
                                    <td>
                                        <img width="50" src="Login/Register" alt="not found">
                                    </td>
                                    <td>{{ $category->created_at }}</td> --}}
                                    <td>
                                        <a class="btn btn-sm btn-info" href="{{ route('category.show', $category->id) }}">Details</a>
                                        <a class="btn btn-sm btn-primary" href="{{ route('category.edit', $category->id) }}">Edit</a>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                            @csrf
                                             @method('DELETE')
                                                <button class="btn btn-sm btn-danger mt-2">Delete</button>
                                        </form>
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
