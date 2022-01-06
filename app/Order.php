<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['card_id', 'order_number','total_price','client_name','client_number'];

    public function cards()
    {
        return $this->belongsTo(Cards::class);

    }//end of cards

}
