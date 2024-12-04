<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatchProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use DataTables;
use Illuminate\Support\Facades\Gate;
use DB;

class ProductController extends Controller
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
        return view('admin.products.index');
    }

    public function getproducts(Request $request)
    {
        $users = Product::query();

        return Datatables::of($users)

        ->addColumn('action', function ($user) {
            return '<div class="actionsec"><a data-toggle="tooltip" data-placement="top" data-original-title="Edit" href="'.route('products.edit',$user->id).'" class="btn btn-icon btn-outline-primary waves-effect"><i data-feather="edit"></i></a><a data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete" data-method="delete" data-alert="Are you sure want to delete?" href="'.route('products.destroy', $user->id).'" class="jquery-postback btn btn-icon btn-outline-primary waves-effect"><i data-feather="trash"></i></a></div>';
        })

        ->editColumn('created_at', function ($user){
            return date('m/d/Y', strtotime($user->created_at) );
        })
        ->addColumn('image', function ($user){
            if($user->image){
                return '<img src="/'.$user->image.'" style="width: 100px;">';
            }else{
                return '';
            }
        })
        ->filter(function ($query) use ($request) {
            if ($request->has('firstname')) {
                $query->where('name', 'like', "%{$request->get('firstname')}%");
            }
            if ($request->has('lastname')) {
                $query->where('type', 'like', "%{$request->get('lastname')}%");
            }

        })
        ->rawColumns(['is_active', 'action','image'])
        ->make(true);
    }

    public function verified()
    {
        // if (Gate::denies('accessPermission', 'user')) {
        //     return redirect('admin/errors/404');
        // }
        $products = Product::all();
        return view('admin.products.verified',compact('products'));
    }

    public function getverifiedProducts(Request $request)
    {
        $users = BatchProduct::with('product')->where('is_verified',1);
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '<div class="actionsec"><a data-toggle="tooltip" data-placement="top" data-original-title="View Batch" href="' . route('batch.show', $user->id) . '" class="btn btn-icon btn-outline-primary waves-effect"><i data-feather="eye"></i></a><a data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete" data-method="delete" data-alert="Are you sure want to delete?" href="' . route('batch.destroy', $user->id) . '" class="jquery-postback btn btn-icon btn-outline-primary waves-effect"><i data-feather="trash"></i></a></div>';
            })
            ->editColumn('updated_at', function ($user) {
                if($user->is_verified){
                    return date('m/d/Y H:i:s', strtotime($user->updated_at));
                }else{
                    return '-';
                }

            })
            ->addColumn('location', function ($user) {
                if($user->location){
                    $loca =unserialize($user->location);
                    return '<p style="width: 200px;">Address : '.$loca['address'].' <br> Lat/Lng : '.$loca['lat'].' / '.$loca['lng'].'</p>';
                }else{
                    return '-';
                }

            })
            ->addColumn('is_verified', function ($user) {
                if($user->is_verified == 0){
                    return '<a href="javascript://" data-id="1" class="btn btn-danger waves-effect waves-float waves-light btn-sm btn-sts">Not Verified</a>';
                }else{
                    return '<a href="javascript://" data-id="1" class="btn btn-success waves-effect waves-float waves-light btn-sm btn-sts">Verified</a>';
                }

            })
            ->filter(function ($query) use ($request) {
                if ($request->get('product') != '') {
                    $query->where('product_id', $request->get('product'));
                }
                if ($request->get('date') != '') {
                    $query->whereDate('updated_at', $request->get('date'));
                }
            })
            ->rawColumns(['is_verified', 'action','location'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user= new Product;
        $roles = Role::where('id','!=',2)->get();
        return view('admin.products.form',compact('user','roles'));
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
            'name' => 'required',
            'image' => 'required',
            'weight' => 'required',
            'type' => 'required',
        ]);

        try {
            $proImages = '';
            $image = $request->file('image');
            if (isset($image)) {

                $imageName = rand() . $image->getClientOriginalName();
                    $image->move(public_path('product'), $imageName);
                    $proImages = 'product/' . $imageName;
            }
            Product::create([
                    'name'=>$request->name,
                    'image'=>$proImages,
                    'weight'=>$request->weight,
                    'type'=>$request->type,
                    'brand'=>$request->brand,
            ]);

            request()->session()->flash('flash_success', 'Product Created successfully.');
            return redirect()->route('products.index');
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
        $user= Product::findorfail($id);
        $roles = Role::where('id','!=',2)->get();
        return view('admin.products.form',compact('user','roles'));
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
        $user= Product::findorfail($id);
        $validated = $request->validate([
            'name' => 'required',
            //'image' => 'required',
            'weight' => 'required',
            'type' => 'required',
        ]);
        try {
            $proImages = '';
            $image = $request->file('image');
            if (isset($image)) {

                $imageName = rand() . $image->getClientOriginalName();
                    $image->move(public_path('product'), $imageName);
                    $proImages = 'product/' . $imageName;
                    $update['image'] =$proImages;
            }

            $update['name'] =$request->name;
            $update['weight'] =$request->weight;
            $update['type'] =$request->type;
            $update['brand'] =$request->brand;
            // if($proImages != ''){
            //     $update['image'] =$proImages;
            // }

            $user->update($update);
            request()->session()->flash('flash_success', 'Product updated successfully.');
            return redirect()->route('products.index');
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
        $user= Product::findorfail($id);
        DB::beginTransaction();
        try {
            $user->delete();

            DB::commit();

            request()->session()->flash('flash_success', 'Product deleted successfully.');
        } catch (QueryException $ex) {
            DB::rollBack();

            request()->session()->flash('flash_error', 'Unable to delete Product, try later');
        }
    }

    public function statusChange($id)
    {
        $user= Product::findorfail($id);
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
