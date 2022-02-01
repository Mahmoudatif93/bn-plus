<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Company;

class CompanyController extends Controller
{
    use ApiResourceTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies=Company::all();
        return $this->apiResponse($companies,200);
    }

    public function allcompanies(Request $request)
    {
        if(isset($request->kind)){
            if($request->kind=="national"){

                $balancenational = Http::withHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ])->post('https://taxes.like4app.com/online/check_balance/', [
                    'deviceId' =>'111',
                    'email' => 'c',
                    'password' => 'c',
                    'securityCode' => 'c',
                    'langId' => 1,
                ]);

                    if( $balancenational->balance > 0){







                    }else{
                        $companies=Company::where('kind','national')->get();
                    }

               
            }else{
                $companies=Company::where('kind','local')->get();
            }
            
        }
        else if($request->name){
            $companies=Company::where('name',$request->name)->get();
        }
        else{
            $companies=Company::all();
        }
        
        return $this->apiResponse($companies,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post=new posts();
        $post->title=$request->title;
        $post->body=$request->body;
        if($post->save()){
           // return response()->json(['status'=>'success']);
           return  $this->apiResponse('',200);
        }else{
          //  return response()->json(['status'=>'error']);
          return $this->apiResponse('','erro to stor post',404);
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
        return posts::find($id);
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
        $post=posts::find($id);
        $post->title=$request->title;
        $post->body=$request->body;
    //  dd($request->title);
        if($post->update()){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
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
        $post= posts::find($id);

        if(  $post->delete()){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }
}
