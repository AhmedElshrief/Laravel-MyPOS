<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static FindOrFail($product_id)
 */
class Product extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['name', 'description'];

    protected $appends = ['image_path', 'profit_percent'];


    public function getImagePathAttribute()
    {
        return asset('uploads/products_images/'.$this->image);
    }


    public function getProfitPercentAttribute()
    {
        $profit = $this->sale_price - $this->buy_price;
        $profit_percent = ($profit * 100) / $this->buy_price;

        return number_format($profit_percent, 2);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }//end of category

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'products_orders');
    }//end of orders



}//End of model
