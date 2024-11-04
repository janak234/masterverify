<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    public function index()
    {
        if(Auth::user()){return redirect()->route('dashboard');
        }else{
        return view('admin.auth.login');}

    }
}
