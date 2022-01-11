<?php
namespace App\Http\Controllers\API;

    trait ApiResourceTrait{



        public function apiResponse($data=null,$error=null,$code=200){
            $array=[
                'data'=>$data,
                'status'=>$code==200 ? true:false,
                'message' =>$error,
            ];
            return response($array,$code);
        }

        public function apiResponse2($count=null,$error=null,$code=200){
            $array=[
                'count'=>$count,
                'status'=>$code==200 ? true:false,
                'message' =>$error,
            ];
            return response($array,$code);
        }
        public function apiResponse3($orderid=null,$error=null,$code=200){
            $array=[
                'order ID'=>$orderid,
                'status'=>$code==200 ? true:false,
                'message' =>$error,
            ];
            return response($array,$code);
        }

    }


?>
