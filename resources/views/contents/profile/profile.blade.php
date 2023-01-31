@extends('layouts.app')

@section('contents')

<div class="container" style="max-width: 500px;">
    <div class="mt-5">
        <form action="{{ route('profile.update', auth()->user()) }}" method="POST">
            @csrf
            @method('PATCH')

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
                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="First name" value="{{ auth()->user()->name }}" required>
                <label for="fullname">Fullname <span class="text-danger">*</span></label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" id="email" placeholder="Email">
                <label for="email">Email <span class="text-danger">*</span></label>

            </div>
            <!--
            <div class="form-floating mb-3" id="show_hide_password">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <label for="password">Password</label>
                <span id="showEye">
                    <i class='bx bxs-hide' id="eye" onclick="showPassword(pass, eye)"></i>
                </span>
            </div>-->

            @include('components.form_errors')

            <input style="width: 100%" type="submit" value="Save Changes" class="btn btn-primary mb-3">
        </form>
    </div>
</div>
@endsection
