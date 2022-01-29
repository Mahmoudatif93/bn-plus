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

        dd($response );
    }

}
