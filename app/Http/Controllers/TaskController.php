<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    public function index()
    {
        $user = User::select('id', 'name', 'email')->where('id', Auth::user()->id)->get();
        return view('contents.task.index')->with('user', $user);
    }

    public function table()
    {
        $tasks = Task::join('users', 'users.id', 'tasks.employee_id')
        ->select('tasks.id', 'tasks.name', 'users.name as users.name', DB::raw('DATE_FORMAT(tasks.deadline, "%m-%d-%Y") as deadline'), 'tasks.status')->where('tasks.user_id', Auth::user()->id);

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
            return '
                <div class="d-flex flex-row bd-highlight mb-2" style="margin-top: 8px">
                    <a href="' . route('tasks.edit', ['task' => $task]) . '" class="btn btn-success m-1">Edit</a>
                    <button onclick="remove('.$task->id.')" class="btn btn-danger m-1">Delete</button>
                </div>
            ';
        })
        ->rawColumns(['progress','actions'])
        ->make(true);
    }

    public function create()
    {
        $users = User::select('id','name')->where('type','=','Employee')->get();
        return view('contents.task.add')->with('users', $users);
    }

    public function store(StoreTaskRequest $request)
    {
        try {
            $empName = User::select('name')->where('id', '=', $request->user)->first();
            Task::create([
                'name' => $request->name,
                'user_id' => Auth::user()->id,
                'employee_id' => $request->user,
                'deadline' => Carbon::createFromDate($request->deadline . $request->timee . ":00"),
                'description' => $request->description,
                'status' => '0'
            ]);

            return redirect()->route('tasks.index')->with('success', 'Task has been published.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops something went wrong.');
        }
    }

    public function show($id)
    {

    }

    public function edit(Task $task)
    {
        $users = User::select('id','name')->where('type','=','Employee')->get();
        return view('contents.task.edit')->with('task', $task)->with('users', $users);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            $task->update([
                'name' => $request->name,
                'employee_id' => $request->user,
                'deadline' => Carbon::createFromDate($request->deadline . $request->timee . ":00"),
                'description' => $request->description
            ]);
            return redirect()->route('tasks.index')->with('success', $request->name . ' has been updated.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops something went wrong');

        }
    }

    public function destroy(Task $task)
    {
        try {
            $name = $task->name;
            $task->delete();

            return redirect()->route('tasks.index')->with('success', $name . ' has been deleted.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops something went wrong');
        }
    }
}
