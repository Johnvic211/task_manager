@extends('layouts.auth')

@section('contents')

<div class="container" style="max-width: 500px">
    <div class="mt-5">

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('sign-up') }}" method="POST">
            <h2 class="text-center mb-3">Sign-up</h2>

            @csrf

            <div class="form-floating mb-3">
                <select name="type" class="form-control" id="type" required>
                    <option value="Employee" @if(old('type')== 'Employee') selected @endif>Employee</option>
                    <option value="Manager" @if(old('type')== 'Manager') selected @endif >Manager</option>
                </select>
                <label for="type">User Type <span class="text-danger">*</span></label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="First name" value="{{ old('fullname') }}" required>
                <label for="fullname">Fullname <span class="text-danger">*</span></label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}" required>
                <label for="email">Email <span class="text-danger">*</span></label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                <label for="password">Password <span class="text-danger">*</span></label>
                <span id="showEye">
                    <i class='bx bxs-hide' id="eye" onclick="showPassword(pass, eye)"></i>
                </span>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password_confirmation" id="password-confirmation" placeholder="Confirm Password" required>
                <label for="password-confirmation">Confirm Password <span class="text-danger">*</span></label>
                <span id="showEye">
                    <i class='bx bxs-hide' id="eye1" onclick="showPassword(pass1, eye1)"></i>
                </span>
            </div>

            @include('components.form_errors')

            <input style="width: 100%" type="submit" value="Create account" class="btn btn-primary mb-3">

            <div class="text-center mb-3">
                Already have an account? <a href="{{ route('sign-in') }}">Sign-in here</a>
            </div>
        </form>
    </div>
</div>

@endsection
