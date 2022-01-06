<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
    

    protected $fillable = ['company_id', 'card_price','card_code','amounts','offer','avaliable','card_image'];

    public function orders()
    {
        return $this->hasMany(Order::class);

    }//end of orders

    public function company()
    {
        return $this->belongsTo(Company::class);

    }//end of user

}
