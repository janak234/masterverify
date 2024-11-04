@extends('layouts.app')

@section('content')

<style>
    body {
	font-size: 15px;
	line-height: normal;
	font-family: Poppins,sans-serif;
	background: #f7f7f7;
	color: #000;
	overflow-x: hidden;
	height: 100vh;
}
input.form-control, textarea.form-control {
	padding: 15px 30px;
	background: #fff !important;
	border-radius: 16px !important;
	border: 0 !important;
	box-shadow: none !important;
	outline: 0 !important;
	font-size: 14px;
	font-weight: 500;
    height: 45px;
	color: #000 !important;
}
.login-form {
	left: unset;
	top: unset;
	transform: unset;
	width: 400px;
	margin: 0 auto;
	position: relative;
	margin-top: 100px;
}
</style>
<section class="login-screen">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="login-form text-center">
                    <h4>Welcome Back!</h4>
                    <p>Please login in to your account</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">

                            <input id="email" type="text" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                        <div class="form-group position-relative">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <i class="toggle-password fas fa-eye-slash"></i>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">
                            {{ __('Login') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
