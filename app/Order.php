<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['card_id', 'client_id','transaction_id','card_price','client_name','client_number','paid'];

    public function cards()
    {
        return $this->belongsTo(Cards::class,'card_id','id');

    }//end of cards

    public function client()
    {
        return $this->belongsTo(Client::class);

    }//end of cards

}
