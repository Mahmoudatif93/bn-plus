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
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYmI5MGU2MDdmMWM3OWM4OTg4YWNmNzQyOGEzMjE0MGE0ZWVmYzc3OWNmOWI1ZGMzZThlNGI2NDJlNzk5ZDkzNTY2Y2IyOWI0MTBhNWMzMjgiLCJpYXQiOjE2NDQzNDQ4ODgsIm5iZiI6MTY0NDM0NDg4OCwiZXhwIjoxNzcwNTc1Mjg4LCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.kOSSstA8f6ZBhRPEDDRWKmzkPzeaQKM3MzueDTMaI7-M5_iWSTnOswPRcbhbuAway1fFxR18sx2mHTLuc6GCvJmrfz8Xe2sDVY5byrt4U0GMRnUUdh-YiLELAmaK0vuhHJKlvWcYEVTN2EVgPbK3sgVoXFOp-l-p6uZ5cxVsw9HVba2LR-eQjrTlBvhg3s3OD1zeMXc-oFb6l7zXg07bLlZ4Ptmtx7ARDeO0OaGG9hFzIlm5fc3qH-9s1I1vO_FikAAd3Ne31uuxij6NpkawuxdYUTAQicX9wZIeU3BsIImrN4r6fVfxy5-tqzCnbXbfwteH4mzXcd2-zdLqyBsYtDGDjxEWFIFtdU8XMeX9m5YokhlG1epWjobrjnO_jcPs-s9Xp6gR7XcDxZZLD-2A19ViMPKNifMcHR0BZ1th3RrtnXBZ34X8yRMqQNuKp3QeliVG4rxb97S8_v4Wbz3zWEBEFjO8qx6lEPCxQyssfu76ngjpGwk9sTSPv1wGTbZIVTjL7bwTJ0xz5-qFEKzoEGILN8MMgk__16lcHBQ4cVCDsAIgzQUh62S3Q0yMxDq6Cyc580QAvzXNNrAPnwCHyJgsUYhrp07_BTl_7bwUKnMA19O_rHdPO0p5fAoGTYAoisWRc7DeM7kfHaKETWErGWDPKyTUlCAHzV3xE9m8s00',
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
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZmZkMDkwZjNhNTZkNjk2NTAyM2M1ODVlNzVlOGZiYzk2YjBlY2ZhNjU4ODE2YWY0ZDEyMjE4YjVhMDlmZTE5NmM5MjhhMWMwY2VjZjlhNmMiLCJpYXQiOjE2NDM0NjQ3NTksIm5iZiI6MTY0MzQ2NDc1OSwiZXhwIjoxNzY5Njk1MTU5LCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.ncI5blD6gGARhGtwdYFPvV-BALDy10Isv8viIIm_L-fwUBJJF6qpwca0ZWnoBB0LmcLXOxOV-N4jYy0JeA1PXzrPJN6EyTLN8du3u0dQAXeJiH717YU8XMw_JIsaVfY-LV1cGegIf8hE69tTBhClTBxvizqCB2yu2M2xLxb4z7Wp3PTSppYWnmVm7ZOU1P0KUH5H_9WuSbIqInjr8dq5AAJQdHcbuubu4uv9q-l18JssiBvxK2WJogZ_cE9FNEJ5y9AI0xJY1_fjoXbGyx1pOolU8HYscL5g6uNtPX-Ir10fbAV6Tj61vlWw2J35KA9oxv9_-Ci5UYdzlPncZ4XqwCtuElUmyp-S_A2Rdi9aAQgMkTZKtRtSUhsLq06g18zg8qAW4xDOSDE-vL-fbLSBBj3mHs3-KBjqrxH5ikLwmpZEH9UkM9yMpIUu11RE8rdbO2uzGMSun9aWTLmwXp8NVeToO3U7c7hVEYuduOHOUPGto_3E4_Tc8L2J85VyiKazeGzAiH3F760THxqelN2iTUqQsFZjvSgESWUvMr-xwKVrwnxiHKgVQ_sCefnheMt8WJ_FbQ6Mau0HOLwVhbQ9N4ePu6_L5itq_aYoUfmcl2cOuqyhzXMQmDBHPt1t7GDYXj6dviMFifAC2BQcLee5f3DEKm8G7epfRwnvlj8LjUk',
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
