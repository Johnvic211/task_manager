<?php

namespace App\Http\Controllers;


use App\Http\Requests\SigninRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SigninController extends Controller
{
    public function index() {
        return view('contents.auth.sign-in');
    }

    public function signIn(SigninRequest $request){
        try {
            if(Auth::attempt(['email' => $request->email,'password' => $request->password,], $request->remember)) {
                if(Auth::user()->type == 'Manager')
                    return redirect()->route('tasks.index');

                    return redirect()->route('published-tasks.index');

            }

            return back()->with('error', 'Invalid credentials');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
