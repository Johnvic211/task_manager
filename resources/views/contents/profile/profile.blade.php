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
            <div class="text-center mb-3">
                <h4>EDIT PROFILE</h4>
            </div>
            <div class="mb-3 mx-1">
                <b>Account type:</b> {{ strtoupper(auth()->user()->type) }}
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="First name" value="{{ auth()->user()->name }}" required disabled>
                <label for="fullname">Fullname <span class="text-danger">*</span></label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" id="email" placeholder="Email" disabled>
                <label for="email">Email <span class="text-danger">*</span></label>

            </div>

            @include('components.form_errors')

            <input style="width: 49.5%" type="button" value="Update Profile" class="btn btn-primary mb-3" onclick="enableForm(this)" id="update">
            <input style="width: 49.5%" type="submit" value="Save Changes" id="save" class="btn btn-primary mb-3" disabled>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function enableForm(button) {
        document.getElementById('fullname').disabled = false
        document.getElementById('email').disabled = false
        document.getElementById('save').disabled = false
        button.disabled = true
    }
</script>
@endsection
