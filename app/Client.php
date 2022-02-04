<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    protected $fillable = ['id','name', 'phone','email','password'];

 

    public function getNameAttribute($value)
    {
        return ucfirst($value);

    }//end of get name attribute

  /*  public function orders()
    {
        return $this->hasMany(Order::class);

    }//end of orders
*/
    


}//end of model
