<?php

namespace App\Admin\Controllers\Math;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;
use App\Models\User;

/**
 * @module 会员管理
 *
 * Class    MemberController
 * @package App\Admin\Controllers\Math
 */
class MemberController extends Controller
{
    /**
     * @permission 会员列表
     *
     *
     */
    public function index(){

        $header = '会员管理';
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('nickname');
            $searcher->equal('gender');
            $searcher->equal('mobile');
        });
        $data = request()->all();
        $users = (new User())->search($searcher)->orderBy('created_at', 'desc')->paginate(10);

        return view('admin::member.members',compact('users','data','header'));
    }
    /**
     * @permission 删除会员
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($user_id){
        $user = (new User())->where('id',$user_id)->first();
        $user->authWechat()->delete();
        $user->delete();
        return response()->json(['status' => 1, 'message' => '成功']);
    }

    /**
     * @permission 数据统计
     *
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(){

        date_default_timezone_set('PRC');
        //过去七天的注册用户
        $past = date('Y-m-d H:i:s', strtotime('-7 days'));
        $today  = date('Y-m-d ').'00:00:00';
        $yesterday = date('Y-m-d H:i:s', strtotime('-1 days'));
        $pastcount = User::where('created_at', '>', $past)->where('created_at','<',$today)->count();
        //过去7天的注册用户
        $yesterdaycount =  User::where('created_at', '>=', $yesterday)->where('created_at','<=',$today)->count();
        //今天注册用户

        $todaycount =  User::where('created_at', '>=', $today)->count();

        $man = User::where('gender','=',1)->count();
        $woman =  User::where('gender','=',2)->count();
        $unkonw =  User::where('gender','=',-1)->count();


       //男女比例
        $charsex = json_encode(array($man,$woman,$unkonw));

        //当前时间
        $now = date('Y-m-d H:i:s');
        //0-10年龄段
        $onetime = date('Y-m-d H:i:s',strtotime('-10 year', time()));
       //10-20年龄段
        $towtime = date('Y-m-d H:i:s',strtotime('-20 year', time()));
        //20-30年龄段
        $threetime = date('Y-m-d H:i:s',strtotime('-30 year', time()));
        //30-40年龄段
        $fourtime = date('Y-m-d H:i:s',strtotime('-40 year', time()));
        //40-50年龄段
        $fivetime = date('Y-m-d H:i:s',strtotime('-50 year', time()));
        //60以后
        $sixtime = date('Y-m-d H:i:s',strtotime('-60 year', time()));
        //0-10岁属于其他
        $one = User::where('birthday','>=',$onetime)->where('birthday','<=',$now)->count();

        $two = User::where('birthday','>=',$towtime)->where('birthday','<=',$onetime)->count();
        $three = User::where('birthday','>=',$threetime)->where('birthday','<=',$towtime)->count();
        $four = User::where('birthday','>=',$towtime)->where('birthday','<=',$threetime)->count();
        $five = User::where('birthday','>=',$threetime)->where('birthday','<=',$fourtime)->count();
        $six = User::where('birthday','>=',$fourtime)->where('birthday','<=',$fivetime)->count();
        $other = User::count()+$one-$two-$three-$four-$five-$six;

        //年龄比例
        $charage = json_encode(array($two,$three,$four,$five,$six,$other));


       return view('admin::member.members-math',compact('pastcount','yesterdaycount','todaycount','charsex','charage'));

    }


}
