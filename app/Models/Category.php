<?php

namespace App\Models;

use \App\Model;
use Illuminate\Support\Facades\DB;
use Tanmo\Search\Traits\Search;
use \App\Models\Program;
class Category extends Model
{
    //
    use Search;
    protected $table = "categorys";

    public function programs(){
        return $this->hasMany(Program::class);
    }

    public function carousel(){
        return $this->hasOne(Carousel::class);
    }
    //当前用户是否订阅
    public function is_user(){
        $user = auth()->user();
        if($user){
           return  DB::table('subscriptions')->where('user_id',$user->id)->where('category_id',$this->id)->count();
        }
        return false;
    }
}
