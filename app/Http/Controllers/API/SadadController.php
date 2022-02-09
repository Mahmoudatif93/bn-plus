<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Order;
use App\Cards;

class SadadController extends Controller
{
    use ApiResourceTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function verify(Request $request)
    {
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2JuLXBsdXMubHkvQk5wbHVzL3B1YmxpYy9hcGkvbG9naW4iLCJpYXQiOjE2NDQzOTAwNzAsImV4cCI6MTY0NDM5MzY3MCwibmJmIjoxNjQ0MzkwMDcwLCJqdGkiOiJzaE1JWVBMTm1YU1RCVlF2Iiwic3ViIjowLCJwcnYiOiIzNzg3ZmJhMTYxOGE5MzA1MjZhY2E2YzhiYjliNDRiODNmMjk3NzI2In0.etwk4A1Qda_57iBf9nEBFosgCTxTQp_euh3L_ErWPBQ',
            'X-API-KEY' => '984adf4c-44e1-418f-829b'
        ])->post('https://api.plutus.ly/api/v1/transaction/sadadapi/verify', [
            'mobile_number' => $request->mobile_number,
            'birth_year' => $request->birth_year,
            'amount' => $request->amount
        ]);

        return $response;
        $card = Cards::where(array('avaliable' => 0, 'purchase' => 0, 'card_price' => $request->amount))->orderBy('id', 'desc')->first();
        if (!empty($card)) {

            
            if (isset($response['error'])) {

                return $this->apiResponse4(false, $response['error']['message'], $response['error']['status']);
            } else {
$process_id=$response['result']["process_id"];

                $request_data['card_id'] = $card->id;
                $request_data['client_id'] = $request->client_id;
                $request_data['card_price'] = $request->amount;
                $request_data['client_name'] = $request->client_name;
                $request_data['client_number'] = $request->client_number;
                $request_data['process_id'] = "$process_id";
                $request_data['invoice_no'] = rand();
               // $order->invoice_no = rand();

               
                $order = Order::create($request_data);

                $dataa['avaliable'] = 1;
                Cards::where('id', $order->card_id)->update($dataa);

                return $this->apiResponse5(true, $response['message'], $response['status'], $response['result'], $order->id);
            }
        } else {
            return $this->apiResponse4(false, 'No Avaliable Cards for this price', 400);
        }

        // dd($response );
    }


    public function confirm(Request $request)
    {

        $idfirst = $request->order_id;
        $orderfirst = Order::find($idfirst);
      if(!empty($orderfirst)){

     
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2JuLXBsdXMubHkvQk5wbHVzL3B1YmxpYy9hcGkvbG9naW4iLCJpYXQiOjE2NDQzOTAwNzAsImV4cCI6MTY0NDM5MzY3MCwibmJmIjoxNjQ0MzkwMDcwLCJqdGkiOiJzaE1JWVBMTm1YU1RCVlF2Iiwic3ViIjowLCJwcnYiOiIzNzg3ZmJhMTYxOGE5MzA1MjZhY2E2YzhiYjliNDRiODNmMjk3NzI2In0.etwk4A1Qda_57iBf9nEBFosgCTxTQp_euh3L_ErWPBQ',
            'X-API-KEY' => '984adf4c-44e1-418f-829b'
        ])->post('https://api.plutus.ly/api/v1/transaction/sadadapi/confirm', [

            'process_id' => $orderfirst->process_id,
            'code' => $request->code,
            'amount' => $request->amount,
            'invoice_no' => $orderfirst->invoice_no,
            'customer_ip' => $request->customer_ip,

        ]);
        if (isset($response['error'])) {
            return $this->apiResponse4(false, $response['error']['message'], $response['error']['status']);
        } else {
            $id = $request->order_id;
            $order = Order::find($id);
            if (!empty($order)) {
                $order->transaction_id = $response['result']['transaction_id'];
                $order->paid='true';

                if ($order->update()) {
                    $updatecard['purchase']=1;
                  Cards:: where('id', $order->card_id)->update( $updatecard);
                    return $this->apiResponse5(true, $response['message'], $response['status'], $response['result']);
                } else {
                    return response()->json(['status' => 'error']);
                }
            } else {
                return response()->json(['status' => 'error']);
            }
        }
    }else{
        return $this->apiResponse4(false, 'no Order for this order id',400);  
    }
    }
}
