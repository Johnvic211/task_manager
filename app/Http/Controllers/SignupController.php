<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function index() {
        return view('contents.auth.sign-up');
    }

    public function signUp(SignupRequest $request){
        try {
            User::create([
                'type' => $request->type,
                'name' => $request->fullname,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return redirect()->route('sign-in')->with('success','Account has been registered');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
