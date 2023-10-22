@extends('layouts/dashboardmaster')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Admin List</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created_at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users->where('role','admin') as $user)
                                        <tr>
                                            <td>
                                                @empty($user->profile_photo)
                                                    <img src="{{ Avatar::create($user->name)->toBase64() }}" width="50"/>
                                                @else
                                                    <img src="{{ asset('uploads/profile_photos') }}/{{ $user->profile_photo }}" alt="not found" width="50">
                                                @endempty
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Vendor List</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Details</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Created_at</th>
                                    </tr>
                                </thead>
                                <style>
                                        .switch {
                                        position: relative;
                                        display: inline-block;
                                        width: 60px;
                                        height: 34px;
                                        }

                                        /* Hide default HTML checkbox */
                                        .switch input {
                                        opacity: 0;
                                        width: 0;
                                        height: 0;
                                        }

                                        /* The slider */
                                        .slider {
                                        position: absolute;
                                        cursor: pointer;
                                        top: 0;
                                        left: 0;
                                        right: 0;
                                        bottom: 0;
                                        background-color:#ccc;
                                        -webkit-transition: .4s;
                                        transition: .4s;
                                        }

                                        .slider:before {
                                        position: absolute;
                                        content: "";
                                        height: 26px;
                                        width: 26px;
                                        left: 4px;
                                        bottom: 4px;
                                        background-color:white;
                                        -webkit-transition: .4s;
                                        transition: .4s;
                                        }

                                        input:checked + .slider {
                                        background-color: #2196F3;
                                        }

                                        input:focus + .slider {
                                        box-shadow: 0 0 1px #2196F3;
                                        }

                                        input:checked + .slider:before {
                                        -webkit-transform: translateX(26px);
                                        -ms-transform: translateX(26px);
                                        transform: translateX(26px);
                                        }

                                        /* Rounded sliders */
                                        .slider.round {
                                        border-radius: 34px;
                                        }

                                        .slider.round:before {
                                        border-radius: 50%;
                                        }
                                </style>
                                <tbody>
                                    @foreach ($users->where('role','vendor') as $user)
                                        <tr>
                                            <td>
                                                @empty($user->profile_photo)
                                                    <img src="{{ Avatar::create($user->name)->toBase64() }}" width="50"/>
                                                @else
                                                    <img src="{{ asset('uploads/profile_photos') }}/{{ $user->profile_photo }}" alt="not found" width="50">
                                                @endempty
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}
                                                {{ $user->phone_number }}
                                            </td>
                                            <td>
                                                {{ ($user->action == true) ? 'active' : 'deactive' }}
                                            </td>
                                            <td>
                                                <form action="{{ route('vendor.action.change', $user->id) }}" method="POST">
                                                    @csrf
                                                    <label class="switch"> <input onchange="this.form.submit()" {{ ($user->action == true) ? 'checked' : '' }} type="checkbox"><span class="slider round"></span></label>
                                                </form>

                                            </td>
                                            <td>{{ $user->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>







                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Users Add
                </div>
                <div class="card-body">
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <li>{{ $error }}</li>
                    </div>
                    @endforeach
                    <form action="{{ route('add_user') }}" method="POST">
                        @csrf
                        <div class="basic-form">
                          <div class="mb-3">
                            <label for="" class="form-label">Admin Name</label>
                            <input type="text" class="form-control" name="name" placeholder="">
                          </div>
                          <div class="mb-3">
                            <label for="" class="form-label">Admin Email</label>
                            <input type="email" class="form-control" name="email_address" placeholder="">
                          </div>
                          <div class="mb-3">
                            <button type="submit" class="btn btn-info">Create New Admin</button>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
