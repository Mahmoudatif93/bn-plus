<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SadadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    public function verify(Request $request)
    {
        $response = Http::post('https://api.sandbox.plutus.ly/api/v1/transaction/sadadapi/verify', [
            'mobile_number' => $request->mobile_number,
            'birth_year' => $request->birth_year,
            'amount'=>$request->amount
        ]);
        
        if(isset($response['error'])){
            return 'error';
            return $response['error'];
        }else{
            return 0;
        }
       
       // dd($response );
    }


    public function confirm(Request $request)
    {
        $response = Http::post('https://api.sandbox.plutus.ly/api/v1/transaction/sadadapi/confirm', [
            'process_id' => $request->process_id,
            'code' => $request->code,
            'amount'=>$request->amount,
            'invoice_no'=>$request->invoice_no,
            'customer_ip'=>$request->customer_ip,
        ]);

        return $response ;
    }




}
