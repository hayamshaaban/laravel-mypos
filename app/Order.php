<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded=[];

    public function client()
    {
     return $this->belongsTo('App\Client');
    }
    public function products()
    {
     return $this->belongsToMany('App\Product','product_order')->withPivot('quantity');
    }
    public function getNameAttribute($value){
        return ucfirst($value);
    }
}
