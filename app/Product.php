<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Astrotomic\Translatable\Translatable;

    protected $guarded= [];
    public $translatedAttributes = ['name','description'];
    protected $appends=['image_path','profit_percent'];

    public function getImagePathAttribute(){
        return asset('uploads/products_images/'.$this->image);
    }
    public function getProfitPercentAttribute(){
        $profit=$this->sale_price -$this->purchase_price;

        $profit_percent=$profit *100/$this->purchase_price;
        return number_format($profit_percent,2);
    }

    
    public function category(){
        return $this->belongsTo('App\Category');
    }
    public function orders()
    {
     return $this->belongsToMany('App\Order','product_order');
    }
    public function getNameAttribute($value){
        return ucfirst($value);
    }
    
}
