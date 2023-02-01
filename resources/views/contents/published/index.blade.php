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
                    <th scope="col" id="deadline">DEADLINE</th>
                    <th scope="col">PROGRESS</th>
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
            title: "Input the percentage % you've finished for the task (0-100)",
            input: 'number',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Submit',
            inputAttributes: {
                min: 0, max: 100
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $form = $('<form id="complete-form" method="POST" action="/published-tasks/'+id+'"></form>')
                $form.append('<input type="text" value="'+result.value+'" name="percent">')
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
            { data: 'users.name' },
            { data: 'deadline' },
            { data: 'progress' },
            { data: 'actions' },
        ],
    });

    document.getElementById('deadline').click()
    document.getElementById('deadline').click()
</script>

@endsection
