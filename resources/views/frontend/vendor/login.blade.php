@extends('layouts.frontendmaster')

@section('content')
<!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
    <ul class="breadcrumb_nav ul_li">
        <li><a href="index.html">Home</a></li>
        <li>Login/Register</li>
    </ul>
    </div>
    </div>
    <!-- breadcrumb_section - end
    ================================================== -->

    <!-- register_section - start
================================================== -->
<section class="register_section section_space">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center mb-5">Vendor Login</h1>
            <div class="register_wrap tab-content">
              <div class="tab-pane fade show active" id="signup_tab" role="tabpanel">


                    <form action="{{ route('vendor.login.post') }}" method="POST">
                        @csrf

                        <div class="form_item_wrap">
                            <h3 class="input_title">Email*</h3>
                            <div class="form_item">
                                <label for="email_input"><i class="fas fa-envelope"></i></label>
                                <input id="email_input" type="email" name="email" placeholder="Customer Email Address">
                            </div>
                        </div>

                        <div class="form_item_wrap">
                            <h3 class="input_title">Password*</h3>
                            <div class="form_item">
                                <label for="password_input2"><i class="fas fa-lock"></i></label>
                                <input id="password_input2" type="password" name="password" placeholder="Customer Password">
                            </div>
                        </div>
                        <div class="form_item_wrap">
                            <button type="submit" class="btn btn_secondary">Login</button>
                        </div>
                      </form>
                    </div>
            </div>
        </div>

    </div>
    </div>
    </section>
    <!-- register_section - end
    ================================================== -->
@endsection
