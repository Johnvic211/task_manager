@extends('layouts.app')

@section('contents')

<div class="container">
    <div class="mt-5">
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-md active mb-4" role="button" aria-pressed="true">< Back</a>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

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
                <input type="text" class="form-control" name="name" id="name" placeholder="Name of task" value="{{ old('name') }}" required>
                <label for="name">Name of task <span class="text-danger">*</span></label>
            </div>

            <div style="display:flex;">
                <div class="form-floating mb-3" style="min-width:49%; margin-right:2%">
                    <input type="date" class="form-control" name="deadline" id="deadline" placeholder="Deadline" value="{{ old('deadline') }}" min="{{ date('Y-m-d') }}" required>
                    <label for="deadline">Deadline <span class="text-danger">*</span></label>
                </div>

                <div class="form-floating mb-3" style="min-width:49%">
                    <input type="time" class="form-control" name="timee" id="timee" placeholder="Time" value="{{ old('timee') }}" min="06:00" required>
                    <label for="time">Time <span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="mb-3">
                <select name="user" class="form-select" id="user" required>
                    <option style="display:none">Select Assigned Employee <span class="text-danger">*</span></option>
                    @forelse ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @empty

                    @endforelse
                </select>
            </div>

            <div class="form-floating mb-3">
                <textarea class="form-control" name="description" id="description" placeholder="Description of task" style="height:100px" required>{{ old('description') }}</textarea>
                <label for="description">Description of task <span class="text-danger">*</span></label>
            </div>

            @include('components.form_errors')

            <input style="width: 100%" type="submit" value="Publish Task" class="btn btn-primary mb-3">
        </form>
    </div>
</div>

@endsection
