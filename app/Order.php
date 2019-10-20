<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];


    public function client(){
        return $this->belongsTo(Client::class);
    }//end of client


    public function products(){
        return $this->belongsToMany(Product::class, 'products_orders')->withPivot('quantity');
    }//end of products


}//end of model
