@extends('layouts.dashboardmaster')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="profile card card-body px-3 pt-3 pb-0">
                <div class="profile-head">
                    <div class="photo-content">
                        <div class="cover-photo" style="background: url('{{ asset('uploads/cover_photos') }}/{{ auth()->user()->cover_photo }}'); background-size:cover; background-position:center;">

                        </div>
                    </div>
                    <div class="profile-info">
                        <div class="profile-photo">
                            @if (auth()->user()->profile_photo)
                              <img src="{{ asset('uploads/profile_photos') }}/{{ auth()->user()->profile_photo }}" class="img-fluid rounded-circle" alt="">

                            @else
                                <img src="{{ Avatar::create(auth()->user()->name)->toBase64() }}" />
                                {{-- <img src="{{ asset('dashboard_assets/images/default_profile_photo.jpg') }}" class="img-fluid rounded-circle" alt=""> --}}
                            @endif
                        </div>
                        <div class="profile-details">
                            <div class="profile-name px-3 pt-2">
                                <h4 class="text-primary mb-0">{{ auth()->user()->name }}</h4>
                                <p>Name</p>
                            </div>
                            <div class="profile-email px-2 pt-2">
                                <h4 class="text-muted mb-0">{{ auth()->user()->email }}</h4>
                                <p>Email</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Profile Edit</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="POST" action="{{ url('profile/photo/update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-1 col-form-label">Profile Photo</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="profile_photo">
                                    @error('profile_photo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-1 col-form-label">Cover Photo</label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" name="cover_photo">
                                    @error('profile_photo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary">Change Photos</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Your Password</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        @if ($errors->any())
                            <div class="alert alert-danger">

                                   @foreach ($errors->all() as $error)
                                     <li>{{ $error }}</li>
                                   @endforeach

                            </div>
                        @endif
                         @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ url('change/password') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Current Password</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Current Password" name="current_password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">New Password</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="New Password" name="password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Re-write Password</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Re-write Password" name="password_confirmation">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Phone Number</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        @if (session('code_success'))
                        <div class="alert alert-success">
                            {{ session('code_success') }}
                        </div>
                    @endif


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Phone Number</label>
                                <div class="col-sm-9">
                                    <p>{{ auth()->user()->phone_number }}</p>
                                     @if ($verification_status)
                                        <span class="badge bg-success text-white">Verified</span>
                                     @else
                                        <span class="badge bg-danger text-white">Un-verified</span>
                                     @endif


                                </div>
                            </div>
                            @if(!$verification_status)
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <a href="{{ url('send/verification/code') }}" class="btn btn-outline-info btn-sm">Verify Now</a>
                                    </div>
                                </div>
                            @endif
                        <form action="{{ url('check/code') }}" method="POST">
                        @csrf
                            @if (session('code_success'))
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Code</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Enter Code" name="code">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
