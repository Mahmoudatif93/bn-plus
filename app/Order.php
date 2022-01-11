<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['card_id', 'order_number','transaction_id','card_price','client_name','client_number','paid'];

    public function cards()
    {
        return $this->belongsTo(Cards::class);

    }//end of cards

}
