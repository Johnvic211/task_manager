@extends('layouts.app')

@section('contents')
<style>

</style>

<div class="container">
    <div class="mt-5">
        <h2>{{ $task->name }}</h2>
        <div style="display:flex">
            <p class="mx-3"><b>Created by:</b>
                {{ $task->user->name }}
            </p>
            <p class="mx-3"><b>Deadline:</b>
                {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y h:i A') }}
            </p>
            <p class="mx-3"><b>Status:</b>
                <span
                @if ($task->status != 'Complete')
                    class="text-danger"
                @else
                    class="text-success"
                @endif>
                    {{ $task->status }}
                </span>
            </p>
        </div>
        <hr/>
        <b>Notes/Description:</b>
        <p>{{ $task->description }}</p>

        <a href="{{ route('published-tasks.index') }}" class="btn btn-secondary btn-md active mb-4" role="button" aria-pressed="true">< Go back</a>
    </div>
</div>
@endsection
