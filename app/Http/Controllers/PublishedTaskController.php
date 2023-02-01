<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UpdateTaskStatusRequest;

class PublishedTaskController extends Controller
{
    public function index() {
        $user = User::select('id', 'name', 'email')->where('id', Auth::user()->id)->get();

        return view('contents.published.index')->with('user', $user);
    }

    public function table() {
        if(Auth::user()->type == 'Employee') {
            $tasks = Task::join('users', 'users.id', 'tasks.employee_id')
            ->select('tasks.id', 'tasks.name', 'users.name as users.name', DB::raw('DATE_FORMAT(tasks.deadline, "%m-%d-%Y") as deadline'), 'tasks.status')->where('tasks.employee_id', Auth::user()->id);
        } else {
            $tasks = Task::join('users', 'users.id', 'tasks.employee_id')
            ->select('tasks.id', 'tasks.name', 'users.name as users.name', DB::raw('DATE_FORMAT(tasks.deadline, "%m-%d-%Y") as deadline'), 'tasks.status');
        }

        return DataTables::of($tasks)
        ->addColumn('progress', function($task){
            $progress = $task->status;

            $progressBar = '<div class="progress"><div class="progress-bar';

            if($progress > -1 && $progress < 26){
                $progressBar .= ' bg-danger';
            } elseif($progress > 25 && $progress < 51){
                $progressBar .= ' bg-warning';
            } elseif($progress > 50 && $progress < 76){
                $progressBar .= ' bg-info';
            } elseif($progress > 75 && $progress < 101){
                $progressBar .= ' bg-success';
            }

            $progressBar .= '" role="progressbar" style="width: '. $progress .'%;" aria-valuenow="'. $progress .'" aria-valuemin="0" aria-valuemax="100">'.$progress.'%</div>
                </div>
            ';

            return $progressBar;
        })
        ->addColumn('actions', function($task){
            $buttons = "<a class='btn btn-primary m-2'  href='". route('published-tasks.view', ['task'=>$task]) . "'>Read</a>";

            if(Auth::user()->type == 'Employee' && $task->status != '100'){
                $buttons .= "<button class='btn btn-success' type='submit' onclick='task_complete(". $task->id .")'>Update</button>";
            }

            return $buttons;
        })
        ->rawColumns(['progress','actions'])
        ->make(true);
    }

    public function view(Task $task) {
        return view('contents.published.view')->with('task', $task);
    }

    public function update(UpdateTaskStatusRequest $request, Task $task) {
        try {
            $task->update([
                'status' => $request->percent
            ]);

            if($task->status < 100)
                return redirect()->route('published-tasks.index')->with('success', $task->name . ' is now ' . $task->status . '% complete');

            return redirect()->route('published-tasks.index')->with('success', $task->name . ' has been completed.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops something went wrong');
        }
    }
}
