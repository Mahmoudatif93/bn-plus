<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Cards;
class CardController extends Controller
{
    use ApiResourceTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards=Cards::with('company')->distinct('card_price')->get()->unique('card_price');
        return $this->apiResponse($cards,200);
    }

    public function localcards()
    {
        $cards=Cards::where('nationalcompany','local')->with('company')->get()->unique('card_price');
        return $this->apiResponse($cards,200);
    }

    public function nationalcards()
    {
        $cards=Cards::where('nationalcompany','national')->with('company')->get()->unique('card_price');
        return $this->apiResponse($cards,200);
    }
    public function cardsbycompany(Request $request)
    {
        $cards=Cards::where('company_id', $request->company_id)->with('company')->get()->unique('card_price');
        return $this->apiResponse($cards,200);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
