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

        
        $cards = Cards::where(array('card_price' => $request->card_price, 'avaliable' => 0))->count();

        if ($cards > 0) {
            $card = Cards::where(array('avaliable' => 0, 'card_price' => $request->card_price))->orderBy('id', 'desc')->first();

            $request_data['card_id'] = $card->id;
            $request_data['client_id'] = $request->client_id;
            $request_data['card_price'] = $request->card_price;
            $request_data['client_name'] = $request->client_name;
            $request_data['client_number'] = $request->client_number;
            $order = Order::create($request_data);

            if($order){
               $dataa['avaliable']=1;
               Cards:: where('id', $order->card_id)->update($dataa);
               return $this->apiResponse3($order->id,200);
            }else{
              return $this->apiResponse3('','error to Reserve Order',404);
            }

        } else {
            $message = "No Cards Avaliable For this Price";
            return $this->apiResponse2($cards, $message, 404);
            
        }


      


        
    }
    public function finalorder(Request $request)
    {
        $id=$request->order_id;
    $order=Order::find($id);
    if(!empty($order)){
        $order->transaction_id=$request->transaction_id;
        $order->paid='true';

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
