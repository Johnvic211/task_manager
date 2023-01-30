@extends('layouts.auth')

@section('contents')

<div class="container" style="max-width: 500px;">
    <div class="mt-5">
        <form action="{{ route('sign-in') }}" method="POST">

            @csrf

            <h5 class="text-center"><b>Login with your email and password.</b></h5>
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3" id="show_hide_password">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <label for="password">Password</label>
                <div class="input-group-addon">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="true">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            @include('components.form_errors')

            <input style="width: 100%" type="submit" value="Login" class="btn btn-primary mb-3">
            <div class="text-center mb-3">Don't have an account? <a href="{{ route('sign-up') }}">Sign-up now</a></div>
        </form>
    </div>
</div>
@endsection
