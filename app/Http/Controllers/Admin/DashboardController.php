<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BatchProduct;
use DataTables;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index(Request $request)
    {   if($request->ajax()){
            if($request->brand || ($request->start || $request->end)){
                $startDate = $request->start ? $request->start : '1970-01-01';
                $endDate = $request->end ? $request->end : now();
                $result['total_product']=Product::when($request->brand, function ($query) use ($request) {
                        $query->where('brand', $request->brand);
                    })->whereBetween('created_at', [$startDate, $endDate])->count();
                $result['product_verified']=BatchProduct::join('products','products.id','batch_products.product_id')->where('is_verified',1)->whereBetween('batch_products.updated_at', [$startDate, $endDate])->when($request->brand, function ($query) use ($request) {$query->where('brand', $request->brand); })->count();
                $result['codes_generated']=BatchProduct::join('products','products.id','batch_products.product_id')->where('code', 'not like', 'MTA%')->whereBetween('batch_products.updated_at', [$startDate, $endDate])->when($request->brand, function ($query) use ($request) {$query->where('brand', $request->brand); })->count();
                $result['total_scan']=BatchProduct::join('products','products.id','batch_products.product_id')->whereYear('batch_products.updated_at', date('Y'))->whereMonth('batch_products.updated_at',date('m'))->where('is_verified',1)->when($request->brand, function ($query) use ($request) {$query->where('brand', $request->brand); })->whereBetween('batch_products.updated_at', [$startDate, $endDate])->count();
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
            $states=BatchProduct::selectRaw('state, COUNT(*) as product_count')->join('products','products.id','batch_products.product_id')->where('is_verified',1);
            if($request->brand_name){
                $states=$states->where('brand',$request->brand_name);
            }
            if($request->start_date && $request->end_date){
                $states=$states->whereBetween('batch_products.updated_at', [$request->start_date,$request->end_date]);
            }
            $states=$states->groupBy('state')->get();  
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
    public function get_map_data(Request $request){
        if($request->ajax()){
                    $metrix=BatchProduct::selectRaw(' state, COUNT(*) as metric')->join('products','products.id','batch_products.product_id')->where('is_verified', 1) ->whereNotNull('state');
                    if($request->brand_name){
                        $metrix=$metrix->where('brand',$request->brand_name);
                    }
                    if($request->start_date && $request->end_date){
                        $metrix=$metrix->whereBetween('batch_products.updated_at', [$request->start_date,$request->end_date]);
                    }
                    $metrix=$metrix->groupBy('state')->get()->map(function ($item) {
                            return [
                                'name' => $item->state,
                                'metric' => $item->metric,
                            ];
                    });    
            return response()->json($metrix, 200);
        }
    }
    public function export_all_code(Request $request){
        list($startDate, $endDate) = explode(' - ', $request->date);
        $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
        $codes=BatchProduct::select('ip_address','code','name','type','brand','weight','city','state','country','zip_code',\DB::raw('DATE_FORMAT(batch_products.updated_at, "%m/%d/%Y %H:%i:%s") as verified_date'))->join('products', 'products.id', '=', 'batch_products.product_id')->where('is_verified', 1);
        if($startDate && $endDate){
            $codes=$codes->whereBetween('batch_products.updated_at', [$startDate, $endDate]);
        }
        if($request->select_brand){
            $codes=$codes->where('brand',$request->select_brand);
        }
        $codes=$codes->get();
        return Excel::download(new class($codes) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $codes;

            public function __construct(Collection $codes)
            {
                $this->codes = $codes;
            }

            public function collection()
            {
                return $this->codes;
            }

            public function headings(): array
            {
                return ['Ip','Code','Name','Type','Brand','Weight','City','State','Country','Zip Code','Verified Date'];
            }
        }, 'verified_codes.xlsx');
    }
}
