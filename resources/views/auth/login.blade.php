@extends('layouts.app')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>OQS</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <p class="login-box-msg">
                    @if (Session::has('errorlogin'))
                        <div class="alert alert-danger">
                            {{ Session::get('errorlogin') }}
                        </div>
                    @endif
                </p>

                <form method="POST" action="{{ route('login') }}" id="login-validation" method="post">

                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus id="exampleInputEmail1"
                            placeholder="Enter email">
                        <input type="hidden" id="fcm_token" name="fcm_token" value="">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            required autocomplete="current-password" id="exampleInputPassword1" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                       
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection
