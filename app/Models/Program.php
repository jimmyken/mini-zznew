<?php

namespace App\Models;

use \App\Model;
use Tanmo\Search\Traits\Search;
use \App\Models\Category;
class Program extends Model
{
    //
    use Search;

    protected $table = "programs";

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }

}
