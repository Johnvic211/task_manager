<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function index(){
        $user = User::select('id', 'name', 'email')->where('id', Auth::user()->id)->get();

        return view('contents.profile.profile')->with('user', $user);
    }

    public function update(UpdateProfileRequest $request, User $user){
        try {
            $user->update([
                'name'=>$request->fullname,
                'email'=>$request->email
            ]);

            return redirect()->route('profile.index', auth()->user())->with('success', 'Profile has been udpated.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }

    }
}
