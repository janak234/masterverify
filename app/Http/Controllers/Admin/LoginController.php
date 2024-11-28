<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
class LoginController extends Controller
{
    public function index()
    {
        if(Auth::user()){return redirect()->route('dashboard');
        }else{
        return view('admin.auth.login');}
    }
    public function change_password(Request $request){
        if($request->isMethod('post')){
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|confirmed',
            ]);
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return back()->withErrors(['old_password' => 'The old password is incorrect.']);
            }
            $user = auth()->user();
            $user->password = Hash::make($request->new_password);
            $user->save();
            return back()->with('flash_success', 'Password changed successfully.');
        }
        return view('admin.change_password');
    }
}
