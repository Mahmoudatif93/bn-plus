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
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZmZkMDkwZjNhNTZkNjk2NTAyM2M1ODVlNzVlOGZiYzk2YjBlY2ZhNjU4ODE2YWY0ZDEyMjE4YjVhMDlmZTE5NmM5MjhhMWMwY2VjZjlhNmMiLCJpYXQiOjE2NDM0NjQ3NTksIm5iZiI6MTY0MzQ2NDc1OSwiZXhwIjoxNzY5Njk1MTU5LCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.ncI5blD6gGARhGtwdYFPvV-BALDy10Isv8viIIm_L-fwUBJJF6qpwca0ZWnoBB0LmcLXOxOV-N4jYy0JeA1PXzrPJN6EyTLN8du3u0dQAXeJiH717YU8XMw_JIsaVfY-LV1cGegIf8hE69tTBhClTBxvizqCB2yu2M2xLxb4z7Wp3PTSppYWnmVm7ZOU1P0KUH5H_9WuSbIqInjr8dq5AAJQdHcbuubu4uv9q-l18JssiBvxK2WJogZ_cE9FNEJ5y9AI0xJY1_fjoXbGyx1pOolU8HYscL5g6uNtPX-Ir10fbAV6Tj61vlWw2J35KA9oxv9_-Ci5UYdzlPncZ4XqwCtuElUmyp-S_A2Rdi9aAQgMkTZKtRtSUhsLq06g18zg8qAW4xDOSDE-vL-fbLSBBj3mHs3-KBjqrxH5ikLwmpZEH9UkM9yMpIUu11RE8rdbO2uzGMSun9aWTLmwXp8NVeToO3U7c7hVEYuduOHOUPGto_3E4_Tc8L2J85VyiKazeGzAiH3F760THxqelN2iTUqQsFZjvSgESWUvMr-xwKVrwnxiHKgVQ_sCefnheMt8WJ_FbQ6Mau0HOLwVhbQ9N4ePu6_L5itq_aYoUfmcl2cOuqyhzXMQmDBHPt1t7GDYXj6dviMFifAC2BQcLee5f3DEKm8G7epfRwnvlj8LjUk',
            'X-API-KEY' => '984adf4c-44e1-418f-829b'
        ])->post('https://api.plutus.ly/api/v1/transaction/sadadapi/verify', [
            'mobile_number' => $request->mobile_number,
            'birth_year' => $request->birth_year,
            'amount' => $request->amount
        ]);


        if (isset($response['error'])) {
            // return 'error';
            return $this->apiResponse4(false,$response['error']['message'],$response['error']['code']);

        } else {


            $order = new Order();
            $order->card_id = $request->card_id;
            $order->client_id = $request->client_id;
            $order->card_price = $request->card_price;
            $order->client_name = $request->client_name;
            $order->client_number = $request->client_number;


            $order->save();
            $dataa['avaliable'] = 1;
            Cards::where('id', $order->card_id)->update($dataa);

            return $this->apiResponse5(true,$response['message'],$response['status'],$response['result'],$order->id);
            //return $response + $order->id;
        }

        // dd($response );
    }


    public function confirm(Request $request)
    {

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZmZkMDkwZjNhNTZkNjk2NTAyM2M1ODVlNzVlOGZiYzk2YjBlY2ZhNjU4ODE2YWY0ZDEyMjE4YjVhMDlmZTE5NmM5MjhhMWMwY2VjZjlhNmMiLCJpYXQiOjE2NDM0NjQ3NTksIm5iZiI6MTY0MzQ2NDc1OSwiZXhwIjoxNzY5Njk1MTU5LCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.ncI5blD6gGARhGtwdYFPvV-BALDy10Isv8viIIm_L-fwUBJJF6qpwca0ZWnoBB0LmcLXOxOV-N4jYy0JeA1PXzrPJN6EyTLN8du3u0dQAXeJiH717YU8XMw_JIsaVfY-LV1cGegIf8hE69tTBhClTBxvizqCB2yu2M2xLxb4z7Wp3PTSppYWnmVm7ZOU1P0KUH5H_9WuSbIqInjr8dq5AAJQdHcbuubu4uv9q-l18JssiBvxK2WJogZ_cE9FNEJ5y9AI0xJY1_fjoXbGyx1pOolU8HYscL5g6uNtPX-Ir10fbAV6Tj61vlWw2J35KA9oxv9_-Ci5UYdzlPncZ4XqwCtuElUmyp-S_A2Rdi9aAQgMkTZKtRtSUhsLq06g18zg8qAW4xDOSDE-vL-fbLSBBj3mHs3-KBjqrxH5ikLwmpZEH9UkM9yMpIUu11RE8rdbO2uzGMSun9aWTLmwXp8NVeToO3U7c7hVEYuduOHOUPGto_3E4_Tc8L2J85VyiKazeGzAiH3F760THxqelN2iTUqQsFZjvSgESWUvMr-xwKVrwnxiHKgVQ_sCefnheMt8WJ_FbQ6Mau0HOLwVhbQ9N4ePu6_L5itq_aYoUfmcl2cOuqyhzXMQmDBHPt1t7GDYXj6dviMFifAC2BQcLee5f3DEKm8G7epfRwnvlj8LjUk',
            'X-API-KEY' => '984adf4c-44e1-418f-829b'
        ])->post('https://api.plutus.ly/api/v1/transaction/sadadapi/confirm', [

            'process_id' => $request->process_id,
            'code' => $request->code,
            'amount' => $request->amount,
            'invoice_no' => $request->invoice_no,
            'customer_ip' => $request->customer_ip,

        ]);
        
        if (isset($response['error'])) {
           // return $response;
           return $this->apiResponse4(false,$response['error']['message'],$response['error']['message']);
        } else {
            $id = $request->order_id;
            $order = Order::find($id);
            if (!empty($order)) {
                $order->transaction_id =$response['result']['transaction_id'];
                $order->paid = $request->paid;
            
                if ($order->update()) {

                    Cards::where('id', $order->card_id)->delete();
                    return $this->apiResponse5(true,$response['message'],$response['status'],$response['result']);
                  //  return response()->json(['status' => 'success']);
                } else {
                    return response()->json(['status' => 'error']);
                }
            } else {
                return response()->json(['status' => 'error']);
            }


            // 
        }
    }
}
