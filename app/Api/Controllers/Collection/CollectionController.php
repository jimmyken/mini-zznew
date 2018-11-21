<?php

namespace App\Api\Controllers\Collection;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
class CollectionController extends Controller
{
    //用户收藏
    public function store(Request $request){
        $date = ['msg' => '收藏失败'];
        //验证
        $user = auth('api')->user();
        if($user && $request->get('new_id')){
            //逻辑
            $collection = (new Collection());
            $collection->user_id= $user->id;
            $collection->new_id=$request->get('new_id');

            $collection->save();

            //返回数据
            $date['msg']='收藏成功';
        }

        return response()->json($date);
    }

}
