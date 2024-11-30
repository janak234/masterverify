<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BatchProduct;
use DataTables;
use DB;
class DashboardController extends Controller
{
    public function index(Request $request)
    {   if($request->ajax()){
            if($request->brand){
                $result['total_product']=Product::where('brand',$request->brand)->count();
                $result['product_verified']=BatchProduct::join('products','products.id','batch_products.product_id')->where('is_verified',1)->where('brand',$request->brand)->count();
                $result['codes_generated']=BatchProduct::join('products','products.id','batch_products.product_id')->where('code', 'not like', 'MTA%')->where('brand',$request->brand)->count();
                $result['total_scan']=BatchProduct::join('products','products.id','batch_products.product_id')->whereYear('batch_products.updated_at', date('Y'))->whereMonth('batch_products.updated_at',date('m'))->where('is_verified',1)->where('brand',$request->brand)->count();
                return response()->json($result, 200);
            }
        }
        $result['total_product']=Product::count();
        $result['product_verified']=BatchProduct::where('is_verified',1)->count();
        $result['codes_generated']=BatchProduct::where('code', 'not like', 'MTA%')->count();
        $result['total_scan']=BatchProduct::whereYear('updated_at', date('Y'))
                        ->whereMonth('updated_at',date('m'))->where('is_verified',1)->count();
        if($request->ajax()){
            return response()->json($result, 200);
        }
        $brands= Product::whereNotNull('brand')->pluck('brand')->unique(); 
        $metrix=BatchProduct::selectRaw(' state, COUNT(*) as metric, AVG(lat) as latitude, AVG(lng) as longitude ') ->where('is_verified', 1) ->whereNotNull('state') ->whereNotNull('lat') ->groupBy('state')->get()->map(function ($item) {
                return [
                    'name' => $item->state,
                    'lat' => $item->latitude,
                    'lon' => $item->longitude,
                    'metric' => $item->metric,
                ];
        });      
        return view('admin.dashboard',compact('result','brands','metrix'));
    }
    public function get_state_wise(Request $request){
        if($request->ajax()){
            $states=BatchProduct::selectRaw('state, COUNT(*) as product_count')->where('is_verified',1)
                        ->groupBy('state')
                        ->get();  
            return Datatables::of($states)->addIndexColumn()->editColumn('state', function ($state) {
                    return $state->state?$state->state:'Unknown';
                })->addColumn('action', function ($state) {
                return '<a data-toggle="tooltip" data-placement="top" data-original-title="Edit" href="javascript:void(0)" class="btn btn-icon btn-outline-primary waves-effect view_detail" id="'.$state->state.'">
                        <i class="ficon" data-feather="eye"></i>
                    </a>';
            })->rawColumns(['action',])->make(true);   
        }   
    }
    public function get_state_wise_detail(Request $request){
        if($request->ajax()){
           $result = BatchProduct::select('name', 'brand', DB::raw('count(*) as count'))
                    ->join('products', 'products.id', '=', 'batch_products.product_id')
                    ->where('is_verified', 1)
                    ->where('state', $request->state)
                    ->groupBy('name', 'brand')
                    ->get();
            return Datatables::of($result)->addIndexColumn()->make(true);
        }          

    }
}
