<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Astrotomic\Translatable\Translatable;

    protected $guarded= [];
    public $translatedAttributes = ['name','description'];
    protected $appends=['image_path'];

    public function getImagePathAttribute(){
        return asset('uploads/products_images/'.$this->image);
    }

    
    public function category(){
        return $this->belongsTo('App\Category');
    }
    
}
