<?php

namespace App\Api\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
class MemberController extends Controller
{
    //修改用户信息
    public function store(Request $request,User $user){
        $date = ['msg' => '修改失败'];
        //验证
        $user = auth('api')->user();
        if( $user && $request->get('gender')&& $request->get('birthday') && $request->get('mobile')){
            //逻辑
            $user->gender=$request->get('gender');
            $user->birthday =$request->get('birthday');
            $user->mobile = $request->get('mobile');

            $user->save();

            //返回数据
            $date['msg']='修改成功';
        }

        return response()->json($date);
    }

}
