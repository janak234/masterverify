<?php

namespace App\Http\Controllers;

use App\Models\BatchProduct;
use Illuminate\Http\Request;
use auth;
use File;
use Mail;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->isMethod('get') && $request->code != '' && $request->code) {
            $code =  $request->code;
            return view('home',compact('code'));
        }else{
            return view('home');
        }
    }

    public function verify(Request $request)
    {
        $code = BatchProduct::with('product','batch')->where('code',$request->code)->first();
        $location = array();
        if($request->address){
            $location['address'] = $request->address;
            $location['lat'] = $request->lat;
            $location['lng'] = $request->lng;
        }
        if(empty($location)){
            $aloc = null;
        }else{
            $aloc = serialize($location);
        }
        if($code){
            $data = array(
                'image'=>$code->product->image,
                'name'=>$code->product->name,
                'weight'=>$code->product->weight,
                'brand'=>$code->product->brand,
                'type'=>$code->product->type,
                'manufacturing'=>$code->batch->manufacturing,
                'expiry'=>$code->batch->expiry,
            );
            if($code->is_verified == 1){
                return response()->json(['msg' => 'Product Alredy Verified','success'=>'1' ,'is_verified'=>$code->is_verified,'data'=>$data]);
            }else{
                BatchProduct::where('id', $code->id)
                ->update([
                    'is_verified' => 1,
                    'ip_address' => $request->ip(),
                    'location' => $aloc,
                    'state' => $request->state?$request->state:null,
                    'lat' => $request->lat?$request->lat:null,
                    'lng' => $request->lng?$request->lng:null,
                ]);
                return response()->json(['msg' => 'Product Verified','success'=>'1','is_verified'=>$code->is_verified,'data'=>$data]);
            }

        }else{
            return response()->json(['error' => '1','msg'=>'No product forund']);
        }
    }


}
