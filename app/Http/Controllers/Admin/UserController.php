<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use DataTables;
use Illuminate\Support\Facades\Gate;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // if (Gate::denies('accessPermission', 'user')) {
        //     return redirect('admin/errors/404');
        // }
        return view('admin.users.index');
    }

    public function getusers(Request $request)
    {
        $users = User::select(['id', 'firstname','lastname', 'role_id', 'email', 'created_at','is_active'])
        ->where('role_id','!=',2)
        ->with('role');
        return Datatables::of($users)

        ->addColumn('action', function ($user) {
            return '<div class="actionsec"><a data-toggle="tooltip" data-placement="top" data-original-title="Edit" href="'.route('users.edit',$user->id).'" class="btn btn-icon btn-outline-primary waves-effect"><i data-feather="edit"></i></a><a data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete" data-method="delete" data-alert="Are you sure want to delete?" href="'.route('users.destroy', $user->id).'" class="jquery-postback btn btn-icon btn-outline-primary waves-effect"><i data-feather="trash"></i></a></div>';
        })

        ->editColumn('created_at', function ($user){
            return date('d/m/Y', strtotime($user->created_at) );
        })
        ->addColumn('is_active', function ($user){
            if($user->is_active == 1){
                return '<a href="'.route('user_status', $user->id).'" data-id="'.$user->id.'" class="btn btn-success waves-effect waves-float waves-light btn-sm btn-sts">Active</a>';
            }else{
                return '<a href="'.route('user_status', $user->id).'" data-id="'.$user->id.'" class="btn btn-danger waves-effect waves-float waves-light btn-sm btn-sts">In Active</a>';
            }
        })
        ->filter(function ($query) use ($request) {
            if ($request->has('firstname')) {
                $query->where('firstname', 'like', "%{$request->get('firstname')}%");
            }
            if ($request->has('lastname')) {
                $query->where('lastname', 'like', "%{$request->get('lastname')}%");
            }
            if ($request->has('email')) {
                $query->where('email', 'like', "%{$request->get('email')}%");
            }
            if ($request->has('role_id')) {
                $query->where('role_id', "$request->get('role_id')");
            }
        })
        ->rawColumns(['is_active', 'action'])
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user= new User;
        $roles = Role::where('id','!=',2)->get();
        return view('admin.users.form',compact('user','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->role_id);
        $validated = $request->validate([
            'firstname' => 'required','lastname' => 'required',
            'email' => 'unique:users,email,',
            //'mobile' => 'unique:users,mobile,',
            'role_id' => 'required',
        ]);

        try {
            User::create([
                    'firstname'=>$request->firstname,
                    'lastname'=>$request->lastname,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'role_id'=>$request->role_id,
                    'mobile'=>$request->mobile,
            ]);

            request()->session()->flash('flash_success', 'User Created successfully.');
            return redirect()->route('users.index');
        } catch (QueryException $e) {
            request()->session()->flash('flash_error', 'Somthing went wrong please try again.');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user= User::findorfail($id);
        $roles = Role::where('id','!=',2)->get();
        return view('admin.users.form',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // if (Gate::denies('editPermission', 'user')) {
        //     Session::flash('fail_msg', 'No permission! Contact administrator ');
        //     return redirect('/admin/users');
        // }
        $user= User::findorfail($id);
        $validated = $request->validate([
            'firstname' => 'required','lastname' => 'required',
            'email' => 'unique:users,email,'.$user->id,
            'role_id' => 'required',
        ]);
        try {
            $update['firstname'] =$request->firstname;
            $update['lastname'] =$request->lastname;
            $update['email'] =$request->email;
            $update['role_id'] =$request->role_id;
            $update['mobile'] =$request->mobile;
            if($request->password){
                $update['password'] =bcrypt($request->password);
            }
            $user->update($update);
            request()->session()->flash('flash_success', 'User updated successfully.');
            return redirect()->route('users.index');
        } catch (QueryException $e) {
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user= User::findorfail($id);
        DB::beginTransaction();
        try {
            $user->delete();

            DB::commit();

            request()->session()->flash('flash_success', 'User deleted successfully.');
        } catch (QueryException $ex) {
            DB::rollBack();

            request()->session()->flash('flash_error', 'Unable to delete user, try later');
        }
    }

    public function statusChange($id)
    {
        $user= User::findorfail($id);
        if($user)
        {
            if ($user->is_active) {
                $user->is_active = 0;
                $user->save();
            } else {
                $user->is_active = 1;
                $user->save();
            }
        }
    }
}
