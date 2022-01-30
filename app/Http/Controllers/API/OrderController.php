<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Cards;
use App\Order;
class OrderController extends Controller
{

    use ApiResourceTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    
    public function reserveorder(Request $request)
    {
      
            $order=new Order();
            $order->card_id=$request->card_id;
            $order->client_id=$request->client_id;
            $order->card_price=$request->card_price;
            $order->client_name=$request->client_name;
            $order->client_number=$request->client_number;
          
           
            if($order->save()){
               // return response()->json(['status'=>'success']);
               $dataa['avaliable']=1;
               Cards:: where('id', $order->card_id)->update($dataa);
               return $this->apiResponse3($order->id,200);
            }else{
              //  return response()->json(['status'=>'error']);
              return $this->apiResponse3('','error to Reserve Order',404);
            }

        
    }
    public function finalorder(Request $request)
    {
        $id=$request->order_id;
    $order=Order::find($id);
    if(!empty($order)){
        $order->transaction_id=$request->transaction_id;
        $order->paid=$request->paid;
    //  dd($request->title);
        if($order->update()){

            Cards:: where('id', $order->card_id)->delete();
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }else{
        return response()->json(['status'=>'error']);
    }
 
}

}
