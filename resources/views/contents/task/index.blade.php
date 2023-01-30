@extends('layouts.app')

@section('contents')
<style>

</style>

<div class="container">
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

        <a class="btn btn-primary mb-2" href="{{ route('tasks.create') }}">&plus; ADD task</a>

        <table class="table" id="tasks-table" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">TASK</th>
                    <th scope="col">ASSIGNED EMPLOYEE</th>
                    <th scope="col">DEADLINE</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>

    function remove(id)
    {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $form = $('<form id="delete-form" method="POST" action="/tasks/'+id+'"></form>')
                $form.append('<input type="hidden" name="_method" value="DELETE">')
                $form.append('<input type="hidden" name="_token" value="'+$("meta[name='csrf-token']").attr('content')+'">')
                $('body').append($form)
                $('#delete-form').submit();
            }
        })
    }

    $('#tasks-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('tasks.table') }}",
        columns:[
            { data: 'id' },
            { data: 'name' },
            { data: 'employee_name' },
            { data: 'deadline' },
            { data: 'status' },
            { data: 'actions' },
        ]
    });
</script>
@endsection
