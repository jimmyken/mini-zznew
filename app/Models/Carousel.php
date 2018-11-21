<?php

namespace App\Models;

use \App\Model;
class Carousel extends Model
{
    //

    protected $table = "carousels";

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
}
