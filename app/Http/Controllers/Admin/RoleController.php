<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Tbls;
use DataTables;
use Illuminate\Support\Facades\Gate;
use DB;

class RoleController extends Controller
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
        return view('admin.roles.index');
    }

    public function getlist(Request $request)
    {
        $roles = Role::where('id','!=',222);
        return Datatables::of($roles)

        ->addColumn('action', function ($role) {
            return '<div class="actionsec"><a data-toggle="tooltip" data-placement="top" data-original-title="Edit" href="'.route('roles.edit',$role->id).'" class="btn btn-icon btn-outline-primary waves-effect"><i data-feather="edit"></i></a><a style="display:none" data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete" data-method="delete" data-alert="Are you sure want to delete?" href="'.route('roles.destroy', $role->id).'" class="jquery-postback btn btn-icon btn-outline-primary waves-effect"><i data-feather="trash"></i></a><a data-toggle="tooltip" data-placement="top" data-original-title="Permissions" href="'.route('permission',$role->id).'" style="display:none" class="btn btn-icon btn-outline-primary waves-effect"><i data-feather="settings"></i></a></div>';
        })

        ->editColumn('created_at', function ($user){
            return date('d/m/Y', strtotime($user->created_at) );
        })
        ->filter(function ($query) use ($request) {
            if ($request->has('name')) {
                $query->where('name', 'like', "%{$request->get('name')}%");
            }
        })
        ->make(true);
    }

    public function create()
    {
        $role= new Role;
        return view('admin.roles.form',compact('role'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        try {
            $role = Role::create([
                    'name'=>$request->name,
            ]);

            Permission::create([
                'role_id'=>$role->id
            ]);
            request()->session()->flash('flash_success', 'Role Created successfully.');
            return redirect()->route('roles.index');
        } catch (QueryException $e) {
            request()->session()->flash('flash_error', 'Somthing went wrong please try again.');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $role= Role::findorfail($id);

        return view('admin.roles.form',compact('role'));
    }

    public function update(Request $request, $id)
    {
        // if (Gate::denies('editPermission', 'user')) {
        //     Session::flash('fail_msg', 'No permission! Contact administrator ');
        //     return redirect('/admin/users');
        // }
        $Role= Role::findorfail($id);
        $validated = $request->validate([
            'name' => 'required',
        ]);
        try {
            $update['name'] =$request->name;

            $Role->update($update);
            request()->session()->flash('flash_success', 'User updated successfully.');
            return redirect()->route('roles.index');
        } catch (QueryException $e) {
            return redirect()->back();
        }

    }

    public function destroy($id)
    {
        $Role= Role::findorfail($id);
        DB::beginTransaction();
        try {
            if($Role){
                if($Role->users->isNotEmpty()){
                    request()->session()->flash('flash_error', 'Delete Failed! User Accounts available for this role.');
                }
                else {
                    $Role->delete();
                    DB::commit();
                    request()->session()->flash('flash_success', 'Role deleted successfully.');
                }
            }
        } catch (QueryException $ex) {
            DB::rollBack();

            request()->session()->flash('flash_error', 'Unable to delete user, try later');
        }
    }

    public function permission($id)
    {
        $permission = Permission::where('role_id', '=', $id)->first();
        $tables = Tbls::get();
        return view('admin.roles.permission',compact('permission','id','tables'));
    }

    public function permission_update(Request $request)
    {
        if(!$request->id){

        request()->session()->flash('flash_error', 'Permissions not available!');
        return redirect('/weaving/roles');}

        $accessStr = $listStr = $searchStr = $viewStr = $addStr = $editStr = $deleteStr = $statusStr = $exportStr = '';

        $access = $request->access;
        $accessStr = ($access) ? implode(',',$access) : '';

        $list = $request->list; $listStr =  ($list) ? implode(',',$list) : '';
        $search = $request->search; $searchStr = ($search) ? implode(',',$search) : '';
        $view = $request->view; $viewStr = ($view) ? implode(',',$view) : '';
        $add = $request->add;  $addStr =  ($add) ? implode(',',$add) : '';
        $edit = $request->edit; $editStr =  ($edit) ? implode(',',$edit) : '';
        $delete = $request->delete; $deleteStr =  ($delete) ? implode(',',$delete) : '';
        $status = $request->status; $statusStr =  ($status) ? implode(',',$status) : '';
        $export = $request->export; $exportStr = ($export) ? implode(',',$export) : '';

        if($request->id) {
            Permission::where('role_id', $request->id)->update(['access' => $accessStr, 'list' => $listStr, 'search' => $searchStr, 'view' => $viewStr, 'add' => $addStr, 'edit' => $editStr,
                'delete' => $deleteStr, 'status' => $statusStr, 'export' => $exportStr,'updated_by' => auth()->user()->id]);
            request()->session()->flash('flash_success', 'Permission updated!');
            return redirect('/weaving/roles');
        }
        else{request()->session()->flash('flash_error', 'Permissions not available!');
            return redirect('/weaving/roles');
        }
    }
}
