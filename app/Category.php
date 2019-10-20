<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * @method static create(array $array)
 */
class Category extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['name'];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
