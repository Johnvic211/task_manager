<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PublishedTaskController extends Controller
{
    public function index() {
        return view('contents.published.index');
    }

    public function table() {
        if(Auth::user()->type == 'Employee') {
            $tasks = Task::join('users', 'users.id', 'tasks.employee_id')
            ->select('tasks.id', 'tasks.name', 'users.name as employee_name', 'tasks.name', DB::raw('DATE_FORMAT(tasks.deadline, "%m-%d-%Y") as deadline'), 'tasks.status')->where('tasks.employee_id', Auth::user()->id);
        } else {
            $tasks = Task::join('users', 'users.id', 'tasks.employee_id')
            ->select('tasks.id', 'tasks.name', 'users.name as employee_name', 'tasks.name', DB::raw('DATE_FORMAT(tasks.deadline, "%m-%d-%Y") as deadline'), 'tasks.status');
        }

        return DataTables::of($tasks)
        ->addColumn('actions', function($task){
            $buttons = "<a class='btn btn-primary m-2'  href='". route('published-tasks.view', ['task'=>$task]) . "'>Read</a>";

            if(Auth::user()->type == 'Employee' && $task->status != 'Complete'){
                $buttons .= "<button class='btn btn-success' type='submit' onclick='task_complete(". $task->id .")'>Finish</button>";
            }

            return $buttons;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function view(Task $task) {
        $published = $task->with('user')->first();
        //return $published;
        return view('contents.published.view')->with('task', $published);
    }

    public function update(Task $task) {
        try {
            $task->update([
                'status' => 'Complete'
            ]);
            return redirect()->route('published-tasks.index')->with('success', $task->name . ' has been completed.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops something went wrong');
        }
    }
}
