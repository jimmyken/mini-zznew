<?php

namespace App\Api\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
class FeedbackController extends Controller
{
    //用户上传反馈
    public function store(Request $request){
        $date = ['msg' => '上传失败'];
       //验证
        $user = auth('api')->user();
      //  return $user;
        if( $user  && $request->get('content')){
            //逻辑
            $feedback = (new Feedback());
            $feedback->name=$user->nickname;
            $feedback->content=$request->get('content');
            $feedback->user_id=$user->id;
            $feedback->save();

            //返回数据
            $date['msg']='谢谢您宝贵的意见';
        }

        return response()->json($date);
    }

}
