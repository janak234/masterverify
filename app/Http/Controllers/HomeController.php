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
            $data = BatchProduct::with('product','batch')->where('code',$request->code)->first();
            $product=[];
            if($data){
              $product = array(
                'image'=>$data->product->image,
                'name'=>$data->product->name,
                'weight'=>$data->product->weight,
                'brand'=>$data->product->brand,
                'type'=>$data->product->type,
                'manufacturing'=>$data->batch->manufacturing?date('m/d/Y',strtotime($data->batch->manufacturing)):'',
                'expiry'=>$data->batch->expiry?date('m/d/Y',strtotime($data->batch->expiry)):'',
               );      
            }
            return view('home',compact('code','product'));
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
                'manufacturing'=>$code->batch->manufacturing?date('m/d/Y',strtotime($code->batch->manufacturing)):'',
                'expiry'=>$code->batch->expiry?date('m/d/Y',strtotime($code->batch->expiry)):'',
            );
            if($code->is_verified == 1){
                return response()->json(['msg' => 'The code you have entered has previously been verified, our verification codes are for single use only. You might have a counterfeit product, please consult your sales representative. <br/>Thank you for using MasterVerify.com','success'=>'1' ,'is_verified'=>$code->is_verified,'data'=>$data]);
            }else{
                BatchProduct::where('id', $code->id)
                ->update([
                    'is_verified' => 1,
                    'ip_address' => $request->ip(),
                    'location' => $aloc,
                    'city' => $request->city?$request->city:null,
                    'state' => $request->state?$request->state:null,
                    'country' => $request->country?$request->country:null,
                    'zip_code' => $request->zip_code?$request->zip_code:null,
                    'lat' => $request->lat?$request->lat:null,
                    'lng' => $request->lng?$request->lng:null,
                ]);
                return response()->json(['msg' => 'Congratulation you have purchased a valid '.$code->product->brand.' product. Please enjoy responsibly. <br>Thank you for using MasterVerify.com','success'=>'1','is_verified'=>$code->is_verified,'data'=>$data]);
            }

        }else{
            return response()->json(['error' => '1','msg'=>'Unfortunately, the code you have entered does not match our system. You might have a counterfeit product, please consult your sales representative.<br/> Thank you for using MasterVerify.com']);
        }
    }


}
