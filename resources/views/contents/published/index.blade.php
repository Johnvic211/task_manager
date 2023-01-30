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


        <table class="table" id="published-tasks-table" style="width:100%">
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
    function task_complete(id)
    {
        Swal.fire({
            title: 'Are you sure you already completed the task?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                $form = $('<form id="complete-form" method="POST" action="/published-tasks/'+id+'"></form>')
                $form.append('<input type="hidden" name="_method" value="PATCH">')
                $form.append('<input type="hidden" name="_token" value="'+$("meta[name='csrf-token']").attr('content')+'">')
                $('body').append($form)
                $('#complete-form').submit();
            }
        })
    }

    $('#published-tasks-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('published-tasks.table') }}",
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
