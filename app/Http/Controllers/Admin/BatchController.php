<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\BatchProduct;
use App\Models\Product;
use DataTables;
use DB;
use Illuminate\Http\Request;
use PDF;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;

class BatchController extends Controller
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
        return view('admin.batch.index');
    }

    public function getbatchpdf($id)
    {
        return Excel::download(new UsersExport($id), 'product_codes.xlsx');

        $products = BatchProduct::where('batch_id',$id)->get();

        //$pdf = PDF::loadView('admin.batch.pdf', compact('products'));
        //return view('admin.batch.pdf', compact('products'));
        $pdf = PDF::loadView('admin.batch.pdf', compact('products'))->setPaper('a4');
        return $pdf->download('product_codes.pdf');
    }

    public function getbatch(Request $request)
    {
        $users = Batch::orderby('id','desc');
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '<div class="actionsec"><a data-toggle="tooltip" data-placement="top" data-original-title="View Batch" href="' . route('batch.show', $user->id) . '" class="btn btn-icon btn-outline-primary waves-effect"><i data-feather="eye"></i></a> <a data-toggle="tooltip" data-placement="top" data-original-title="Export" href="' . route('getbatchpdf', $user->id) . '" class="btn btn-icon btn-outline-primary waves-effect"><i data-feather="file-text"></i></a><a data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete" data-method="delete" data-alert="Are you sure want to delete?" href="' . route('batch.destroy', $user->id) . '" class="jquery-postback btn btn-icon btn-outline-primary waves-effect"><i data-feather="trash"></i></a></div>';
            })
            ->editColumn('manufacturing', function ($user) {
                return $user->manufacturing?date('m/d/Y',strtotime($user->manufacturing)):'';
            })
            ->editColumn('expiry', function ($user) {
                return $user->expiry?date('m/d/Y',strtotime($user->expiry)):'';
            })
            ->editColumn('created_at', function ($user) {
                return date('m/d/Y',strtotime($user->created_at));
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('firstname')) {
                    $query->where('id', 'like', "%{$request->get('firstname')}%");
                }
                if ($request->has('lastname')) {
                    //$query->where('type', 'like', "%{$request->get('lastname')}%");
                }
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }

    public function getbatchpro(Request $request)
    {
        $users = BatchProduct::with('product')->where('batch_id',$request->id);
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
                if ($request->has('firstname')) {
                    $query->where('id', 'like', "%{$request->get('firstname')}%");
                }
                if ($request->has('lastname')) {
                    //$query->where('type', 'like', "%{$request->get('lastname')}%");
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
        $user = new Product;
        $Products = Product::paginate(4);
        return view('admin.batch.form', compact('user', 'Products'));
    }

    public function loadMore(Request $request)
    {
        $products = Product::paginate(4, ['*'], 'page', $request->page);
        return view('admin.batch.loadmore', compact('products'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->products){
             request()->session()->flash('flash_error', 'Please Select atleast One product.');   
        }
        $validated = $request->validate([
            // 'prefix' => 'required',
            // 'manufacturing' => 'required',
            // 'expiry' => 'required',
            'no_code' => 'required_without:excel_file',
            'excel_file' => 'required_without:no_code|file|mimes:xls,xlsx,csv|max:2048', 
            'products' => 'required',
        ]);
        try {
            if ($request->hasFile('excel_file')) {
                $file = $request->file('excel_file');
                $data = Excel::toArray(new class implements ToArray {
                    public function array(array $array)
                    {
                        return $array;
                    }
                }, $file);
                $codes=$data[0];
                $icodes=array_filter(array_column(array_slice($codes, 1), 0));
            }
            if(empty($icodes) && !$request->no_code){
                request()->session()->flash('flash_error', 'Somthing went wrong please try again.');   
            }
            $batch = Batch::create([
                'prefix' => $request->prefix,
                'manufacturing' => $request->manufacturing,
                'expiry' => $request->expiry,
            ]);
            if ($request->products) {
                if(isset($icodes) && $request->hasFile('excel_file')){
                    foreach ($icodes as $key => $value) {
                        BatchProduct::create([
                            'batch_id' => $batch->id,
                            'product_id' => $request->products,
                            'code' => $value,
                        ]);
                    };    
                }else{
                    $count = $request->no_code;
                    for ($i = 1; $i <= $count; $i++) {
                        $code = $this->generateUniqueCode();
                        BatchProduct::create([
                            'batch_id' => $batch->id,
                            'product_id' => $request->products,
                            'code' => $request->prefix.$request->products.$code,
                        ]);
                    }    
                }
            }
            request()->session()->flash('flash_success', 'Batch Created successfully.');
            return redirect()->route('batch.index');
        } catch (QueryException $e) {
            request()->session()->flash('flash_error', 'Somthing went wrong please try again.');
            return redirect()->back();
        }
    }

    // public function generateUniqueCode($prefix, $batchId)
    // {
    //     $uniqueIdentifier = uniqid();
    //     $code = $prefix . substr(md5($uniqueIdentifier), 0, 6) . $batchId;
    //     while (BatchProduct::where('code', $code)->exists()) {
    //         $uniqueIdentifier = uniqid();
    //         $code = $prefix . substr(md5($uniqueIdentifier), 0, 6) . $batchId;
    //     }
    //     return $code;
    // }

    function generateUniqueCode() {
        $batch = Batch::latest()->first();

        if ($batch) {
            $lastCode = $batch->code;
            $lastId = $batch->batch_id;
            $newCode = substr(md5(time() . $lastId . uniqid()), 0, 8);
            return $newCode;
        } else {
            return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
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
        $batch= Batch::findorfail($id);

        return view('admin.batch.view',compact('batch'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $user= Product::findorfail($id);
        // $roles = Role::where('id','!=',2)->get();
        // return view('admin.batch.form',compact('user','roles'));
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
        $user = Product::findorfail($id);
        $validated = $request->validate([
            'name' => 'required',
            //'image' => 'required',
            'weight' => 'required',
            'type' => 'required',
        ]);
        try {
            //$proImages = '';
            $image = $request->file('image');
            if (isset($image)) {
                $imageName = rand() . $image->getClientOriginalName();
                $image->move(public_path('product'), $imageName);
                $proImages = 'product/' . $imageName;
            }
            $update['name'] = $request->name;
            $update['weight'] = $request->weight;
            $update['type'] = $request->type;
            $update['brand'] = $request->brand;
            if ($proImages) {
                $update['image'] = $proImages;
            }
            $user->update($update);
            request()->session()->flash('flash_success', 'Product updated successfully.');
            return redirect()->route('batch.index');
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
        $user = Batch::findorfail($id);
        DB::beginTransaction();
        try {
            BatchProduct::where('batch_id', $id)->delete();
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
        $user = Product::findorfail($id);
        if ($user) {
            if ($user->is_active) {
                $user->is_active = 0;
                $user->save();
            } else {
                $user->is_active = 1;
                $user->save();
            }
        }
    }
    public function import_code(Request $request){
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $data = Excel::toArray(new class implements ToArray {
                public function array(array $array)
                {
                    return $array;
                }
            }, $file);
            return $data[0];
            return response()->json(['success' => 'File uploaded successfully.']);
        }
    }
}
