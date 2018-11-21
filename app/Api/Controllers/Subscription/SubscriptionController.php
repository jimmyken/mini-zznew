<?php

namespace App\Api\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategorysResource;
use App\Models\Category;
use App\Models\Subscription;
use Illuminate\Http\Request;
class SubscriptionController extends Controller
{
    //用户订阅
    public function store(Request $request){
        $date = ['msg' => '订阅失败'];
        //验证
        $user = auth('api')->user();

        if($user && $request->get('category_id') ){
            //逻辑
            $subscription = (new Subscription());
            $subscription->user_id =$user->id;
            $subscription->category_id=$request->get('category_id');

            $subscription->save();

            //返回数据
            $date['msg']='订阅成功';
        }

        return response()->json($date);
    }

    //用户取消订阅
    public function destroy(Category $category){
        $user = auth('api')->user();
        $user->subscriptions()->detach($category->id);
        $date = ['msg' => '取消订阅成功'];
        return response()->json($date);
    }

    //用户订阅列表
    public function show(){
        $user = auth('api')->user();
        $subscriptions = $user->subscriptions;
        return api()->collection($subscriptions,CategorysResource::class);
    }

}
